<!-- Confirmation Modal -->
<div class="modal fade" id="confirmTreatmentModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Treatment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p id="confirmTreatmentMessage"></p>
        <input type="hidden" id="confirmLoopIteration" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="proceedToInputBtn">Yes, Continue</button>
      </div>
    </div>
  </div>
</div>

<!-- Input Modal -->
<div class="modal fade" id="alignerInputModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Specify Aligners</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <label for="alignerInput" class="form-label">Which Aligners would you like to receive?</label>
        <input type="text" class="form-control" id="alignerInput" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="submitTreatmentBtn">Submit</button>
      </div>
    </div>
  </div>
</div>


<!-- New Treatment Confirm Modal -->
<div class="modal fade" id="newTreatmentConfirmModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm New Treatment Plan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>Do you really want to order a new treatment plan for <strong id="confirmName"></strong>?</p>
        <input type="hidden" id="newTreatmentLoop" />
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" id="confirmNewTreatmentBtn">Yes, Continue</button>
      </div>
    </div>
  </div>
</div>

<!-- Aligner Input Modal -->
<div class="modal fade" id="alignerTrackModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Aligners Lost Track</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <label for="alignerTrackInput">Aligners lost track at number:</label>
        <input type="number" class="form-control" id="alignerTrackInput" />
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" id="submitNewTreatmentBtn">Submit</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="confirm-delete-modal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <p id="confirm-delete-modal-message">Are you sure you want to delete this patient?</p>
      </div>

      <div class="modal-footer">
        <form id="delete-patient-form" method="POST">
            @csrf

            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary ">Yes , I am sure</button>
        </form>
      </div>

    </div>
  </div>
</div>

<!-- doctor-reminder-modal -->
<div class="modal fade" id="doctor-reminder-modal" tabindex="-1" aria-labelledby="doctorReminderModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="doctorReminderModalLabel">Doctor Reminder</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <p>Please set a reminder for this patient.</p>
        <div class="mb-3">
           <label for="reminder-datetime" class="form-label">Reminder Date & Time</label>
          <input type="datetime-local" class="form-control" id="reminder-datetime" name="reminder_datetime" required>
        </div>
        <div class="mb-3">
          <label for="reminder-note" class="form-label">Note</label>
          <textarea class="form-control" id="reminder-note" name="reminder_note" rows="3" placeholder="Add a note..."></textarea>
        </div>
        <div class="mb-3">
          <label for="reminder-note" class="form-label">Attachments</label>
          <input type="file" class="form-control" id="setreminderAttachments" name="setreminderAttachments" multiple>
        </div>
      </div>

      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button id="set-reminder-button" type="button" class="btn btn-primary">Set Reminder</button>
        </form>
      </div>

    </div>
  </div>
</div>



<div class="modal fade" id="rejectConfirmModal" tabindex="-1" aria-labelledby="rejectConfirmLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="rejectConfirmLabel">Confirm Rejection</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <p id="confirm-delete-modal-message">Are you sure you want to reject this treatment plan?</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary " id="confirmReject">Yes , I am sure</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="reopen-case-modal" tabindex="-1" aria-labelledby="reopenModalLabel" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="reopenModalLabel">Confirm Reopen Case</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <p id="confirm-delete-modal-message">Are you sure you want to reopen case?</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary " id="confirm-reopen-case">Yes , I am sure</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="lab-cancel-request-modal" tabindex="-1" aria-labelledby="labCancelRequestLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="labCancelRequestLabel">Confirm Cancel Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <p id="confirm-delete-modal-message">Are you sure you want to cancel request?</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary " id="confirm-lab-cancel-request">Yes , I am sure</button>
            </div>
        </div>
    </div>
</div>

<!--Treatment Planning Service Modal -->
<div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title" id="pricingModalLabel">Pricing Information</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <ul class="list-unstyled mb-0">
            <li>⭐ <strong>First treatment plan:</strong> €200</li>
            <li>⭐ <strong>Further treatment plans:</strong> €100</li>
            </ul>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>

        </div>
    </div>
</div>

<!--Treatment Planning Service Modal -->
<div class="modal fade" id="updatePackageAdminModal" tabindex="-1" aria-labelledby="updatePackageAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updatePackageAdminModalLabel">Update Package</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="updatePackageAdminMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="updatePackageAdminBtn">Yes, I'm Sure</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="precision-cuts-placement-modal" tabindex="-1" aria-labelledby="precision-cuts-placement-modal-Label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="precision-cuts-placement-modal-Label">Precision Cuts Placement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <img src="{{ asset('public/assets/Precision-Cut.png') }}" alt="Precision Cuts Placement" class="img-fluid shadow-sm">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
{{-- cutouts-placement-modal --}}
<div class="modal fade" id="cutouts-placement-modal" tabindex="-1" aria-labelledby="cutouts-placement-modal-Label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="cutouts-placement-modal-Label">Cutouts Placement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <img src="{{ asset('public/assets/Cutout.png') }}" alt="Precision Cuts Placement" class="img-fluid shadow-sm">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- i-hook-modal --}}
<div class="modal fade" id="i-hook-modal" tabindex="-1" aria-labelledby="i-hook-modal-Label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="i-hook-modal-Label">I-Hook</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <img src="{{ asset('public/assets/I-Hooks.jpg') }}" alt="Precision Cuts Placement" class="img-fluid shadow-sm">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- bite-keeper-modal --}}
<div class="modal fade" id="bite-keeper-modal" tabindex="-1" aria-labelledby="bite-keeper-modal-Label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="bite-keeper-modal-Label">Bite Keeper</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <img src="{{ asset('public/assets/bite-keeper.png') }}" alt="Precision Cuts Placement" class="img-fluid shadow-sm">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- secret-wings-modal --}}
<div class="modal fade" id="secret-wings-modal" tabindex="-1" aria-labelledby="secret-wings-modal-Label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="secret-wings-modal-Label">SECRET Wings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <img src="{{ asset('public/assets/secret-wings.png') }}" alt="Precision Cuts Placement" class="img-fluid shadow-sm">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- add-pontic-modal --}}
<div class="modal fade" id="add-pontic-modal" tabindex="-1" aria-labelledby="add-pontic-modal-Label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="add-pontic-modal-Label">Add Pontic</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <img src="{{ asset('public/assets/pontic.jpg') }}" alt="Precision Cuts Placement" class="img-fluid shadow-sm">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- add-bite-turbos-modal --}}
<div class="modal fade" id="add-bite-turbos-modal" tabindex="-1" aria-labelledby="add-bite-turbos-modal-Label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="add-bite-turbos-modal-Label">Add Bite Turbos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <img src="{{ asset('public/assets/bite-turbos.png') }}" alt="Precision Cuts Placement" class="img-fluid shadow-sm">
                    </div>
                    <div class="col-6">
                        <img src="{{ asset('public/assets/bite-turbos-2.png') }}" alt="Precision Cuts Placement" class="img-fluid shadow-sm">
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

