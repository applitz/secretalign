# Image Auto-Segregation — Step-4 UI/Behavior Improvements

Date: 2026-09-18
Branch: `feature/image-auto-segregation` (off `development-new`)
Scope: 5 improvements to the Images / X-Rays wizard step (tab 4).

All work is in `resources/views/patients/create-patients/images-xray.blade.php`
(self-contained `<script>` IIFE scoped to `#pill-tab-div3`) except task 2's backend.
A second session is concurrently editing `app/Http/Services/ImageClassifierService.php`
and `config/services.php` — **do not touch those files**; task 2's backend is isolated.

## Current behavior (baseline)
- Bulk uploader: Select images / Select folder / drag-drop → client filters to images,
  dedupes by content hash, rejects >15, resizes to 768px, POSTs to
  `POST /patient/{id}/images/classify` (`ImageClassifierController@classify`).
- High-confidence results are placed into empty slots via `window.dropzone_upload(key, file)`
  (immediate chunk-upload to `/handle-dropzone-files`, which persists the filename on the
  treatment plan). Low-confidence / collisions go to the client-only "Needs your review"
  row (`#autoseg-review-list`) — held as object URLs, never uploaded.
- Slots (`._dropzone`, keys 3..13) show the photo as background; hover overlay
  (`.autoseg-actions`) has Change type / Edit / Delete.
- Next (`#submit-images`) validates slots 3..12 filled, then `save_images` persists only
  `fl_general_upload_drive_link` (the `#general_upload_hyperlink` value).

## Tasks

### 1. Delete (×) on review cards
Small round × button, top-right of each review card, on hover. Click → remove card +
`URL.revokeObjectURL`. Client-only.

### 2. Merge Drive link + drag-drop; AI-scan from Drive
- **UI**: split the auto-seg card — left = drag-drop + Select buttons; right = Drive link
  input + "Scan link" button. Relocate the existing `#general_upload_hyperlink` input into
  this panel (keep id/name so `save_images` still saves it); remove the old bottom
  "General Upload (Drive Link)" block.
- **Backend (isolated)**: new `DriveImportController@fetch` → `POST /patient/{id}/images/drive-fetch`.
  Validates link (reuse `isGoogleDriveLink`, `checkTreatmentLinkIsPublicOrNot`), lists image
  files via new `listPublicDriveImages()` helper (mirror of `listPublicDriveFiles`, filters
  jpg/jpeg/png/webp/gif/bmp/heic), downloads each (`uc?export=download&id=`), GD-resizes to
  768 JPEG, returns `{status, images:[{name,data_uri}], skipped:[]}` (max 15). Also handles a
  single `/file/d/{id}/` link.
- **Client**: "Scan link" → POST to `drive-fetch` → convert data URIs to `File`s → feed the
  existing classify + placement pipeline (`handleFiles`).
- Reuses the pre-existing hardcoded Google API key in `app/Helper/GoogleDrive.php`; no new
  credentials/config. (That key living in git is a pre-existing security smell — out of scope.)
- Requires the Drive folder/file be shared "anyone with the link".

### 3. Don't persist unassigned images on Next/Save
Verify: `save_images` only saves the drive link; review items never reach the server.
Guard: on Next, clear the review row + revoke its object URLs so nothing lingers; confirm
Next isn't blocked by leftover review items. No server change.

### 4. "Unassign" on assigned slots
Add an **Unassign** action to the hover overlay. `grabSlotFile(key)` → `dropzone_destroy_state(key)`
→ `addReviewItem(file, slotName)`. Keeps the image (back to review); Delete stays permanent.

### 5. Drag a review card onto a slot
Review thumbnails `draggable`; `dragover`/`drop` on each `._dropzone`. On drop, run the
existing Place logic into that slot (bump occupant to review if occupied).

## Testing
Test in the running wizard (`/patient/create` as doctor) with `~/Downloads/_Patient*.zip`
sets. Verify manual per-slot upload and the rest of the wizard still work.

## Constraints
- No PHI in git. Commit on the branch; do not push/merge.
- Pre-existing landmine (not ours): leftover `dd($key)` ~line 556 in
  `PatientFileController@file_upload_new` non-chunk path.
