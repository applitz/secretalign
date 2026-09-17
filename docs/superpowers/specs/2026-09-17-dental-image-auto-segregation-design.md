# Dental Image Auto-Segregation — Design Spec

**Date:** 2026-09-17
**Branch target:** `development-new` (test locally first, then merge)
**Status:** Approved design, pending spec review

## 1. Goal

On the **Images / X-Rays** step (step 4) of the Create-Patient wizard, let a user
upload a whole folder (or drag-and-drop / pick multiple images) of a patient's
orthodontic photos and X-rays. The system uses a vision LLM (Google Gemini via
OpenRouter) to classify each image and drop it into the correct existing slot
automatically. Anything the AI can't place confidently is shown for one-click
manual assignment via a dropdown.

This is additive: the existing 11 per-slot dropzones stay exactly as they are.

## 2. Existing mechanism (reused, not replaced)

- View partial: `resources/views/patients/create-patients/images-xray.blade.php`
  (included by `resources/views/patients/add_patient.blade.php`).
- Each slot is a `_dropzone` with a numeric `key` and a hidden `file{key}` input.
- Upload endpoint: `POST /patient/file/uploadnew/{patient_id}/{treatment_plan_id}?key={key}`
  → `PatientFileController@file_upload_new` (chunked upload, maps key→column via
  `getFileColumn($key)`).
- JS `dropzone_upload(key, file)` in `add_patient.blade.php` chunk-uploads a file
  to a slot and renders its preview / active state.

**Slot ↔ key map (from `getFileColumn`):**

| key | slot | column |
|----|------|--------|
| 3 | Front | fl_front |
| 4 | Smile | fl_smile |
| 5 | Profile | fl_profile |
| 6 | Frontal (Intraoral) | fl_frontal |
| 7 | Right Buccal | fl_right_buccal |
| 8 | Left Buccal | fl_left_buccal |
| 9 | Upper Occlusal | fl_upper_occlusal |
| 10 | Lower Occlusal | fl_lower_occlusal |
| 11 | Panorex | fl_panorex |
| 12 | Lateral Ceph | fl_lateral_ceph |
| 13 | General Upload | fl_general_upload |

## 3. Chosen architecture

**Server classifies, browser places using the existing uploader.**

Rejected alternatives:
- *Server does everything (classify + store):* bypasses the working chunked
  upload + preview JS and duplicates storage logic; higher server memory.
- *Classify in the browser:* would expose the OpenRouter API key in client JS.

## 4. Client flow (new bulk panel at top of the step)

1. New "Auto-upload folder / images" panel above the slots: an **Upload** button,
   a **drag-and-drop** area, and a **folder** input (`webkitdirectory`).
2. Filter incoming items to photos (`jpg/jpeg/png/webp/heic`). Non-image files
   (STL/PLY/DICOM/PDF/etc.) are **skipped and listed** in a "Skipped files" note.
3. If photo count **> 15 → reject the whole batch** with a clear message (the 15
   limit counts photos only; skipped non-images do not count).
4. Resize each photo in-browser to 768px longest edge (canvas, JPEG q80); if
   resize fails for a file, fall back to sending the original. POST the small
   copies to the classify endpoint. Show "Classifying N images…".
5. On response, for each photo:
   - If slot is one of the 10 specific slots **and** confidence ≥ 0.6 **and**
     that slot is currently empty → auto-place by calling
     `dropzone_upload(key, file)` with the **full-res original** file.
   - Otherwise (low confidence, AI said "General Upload", duplicate slot that lost
     the tie, or classify error) → add to a **"Needs review"** list: thumbnail +
     a dropdown of the 11 slot types, pre-selected to the AI's best guess.
     Choosing a slot places the file via the same `dropzone_upload(key, file)`.

Placement rules:
- Auto-fill only **empty** slots — never overwrite a slot the user already filled.
- If two photos map to the same slot, the **higher-confidence** one wins; the
  other goes to Needs-review.

## 5. Server: classify endpoint

`POST /patient/{patient_id}/images/classify` (auth-protected, scoped to patient).

- Receives the small resized images (multipart).
- **Pass 1:** classify every image in parallel with `Http::pool()` — Prompt A,
  `temperature: 0`, model `google/gemini-2.5-flash-lite`, base64 data URIs.
  One retry + a fallback model on failure/timeout.
- **Pass 2 (buccal):** collect images Pass 1 labeled as any "Buccal" and send the
  two together in one comparison call (Prompt B) to reliably assign Right vs Left.
- Confidence gate: `< 0.6` → returned as low-confidence (client routes to review).
- Returns JSON: `[{ "index": <int>, "slot": "<slot>", "confidence": <0..1> }]`.

Prompts A and B are taken verbatim from the implementation guide
(`~/Desktop/dental-auto-segregation-guide.md`, sections 4 and 5).

New controller: `app/Http/Controllers/ImageClassifierController.php` (or a service
`app/Http/Services/ImageClassifierService.php` called from it).

## 6. Config / secrets

- New block in `config/services.php`:
  ```php
  'openrouter' => [
      'key'   => env('OPENROUTER_KEY'),
      'model' => env('OPENROUTER_MODEL', 'google/gemini-2.5-flash-lite'),
      'fallback_model' => env('OPENROUTER_FALLBACK_MODEL', 'google/gemini-2.5-flash'),
  ],
  ```
- `OPENROUTER_KEY` lives only in `.env` (server-side). Key starts with `sk-or-v1-`.

## 7. Error handling

- Per-image classify failure never blocks the batch — that image → Needs-review.
- Endpoint validates: auth, patient ownership, count ≤ 15, mime is an image.
- Network/timeout to OpenRouter: retry once, then fallback model, then mark the
  image low-confidence.

## 8. Local environment (Phase 0)

PHP/Composer/MySQL are not installed; there is no `.env`/`.env.example`.

1. `brew install php@8.1 mysql` + Composer (official installer to avoid pulling a
   second PHP); required extensions: gd, zip, bcmath, mbstring.
2. Create DB `secretalign`; write a fresh `.env` reconstructed from `config/*.php`;
   `php artisan key:generate`.
3. `composer install`; `php artisan migrate` (24 migrations); seed a login user
   (`UserTableSeeder`, plus Shining3D seeders as needed).
4. `php artisan serve` → http://localhost:8000; log in with the seeded user.

Risks: earlier wizard steps may require external integration keys before step 4 is
reachable — if so, add a small isolated test route to validate classification
independently. Assets appear precompiled in `public/`, so avoid an `npm` rebuild
unless required (Node 26 may be too new for this project's Laravel Mix).

## 9. Testing

- Validate the classify endpoint in isolation with a handful of real sample images
  (proven ~100% in the guide) before wiring the full UI.
- Then exercise the full bulk-upload UI on the running app.
- Verify: >15 rejection, non-image skip note, auto-placement into empty slots,
  buccal L/R correctness, and manual dropdown assignment.

## 10. Out of scope

- No changes to the existing per-slot dropzones or other wizard steps.
- No self-hosted/offline model (noted as a future privacy option in the guide).
- Cleanup of committed secrets (`sql.txt`, stray `.env` files, `adminer.php`) is a
  separate security task, tracked outside this spec.

## 11. Security / privacy note

Images are sent to a third-party model provider (OpenRouter → Google). If the
practice is HIPAA/GDPR-strict, a data agreement or a self-hosted model is required.
Flag to stakeholders before production rollout.
