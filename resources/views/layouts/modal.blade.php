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


<div class="modal fade" id="lab-cancel-request-after-submit-modal" tabindex="-1" aria-labelledby="labCancelRequestLabel" aria-hidden="true">
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
                <button type="submit" class="btn btn-primary " id="confirm-lab-cancel-request-after-submit">Yes , I am sure</button>
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


{{-- shining3d-organization-name-modal --}}
<div class="modal fade" id="shining3d-organization-name-modal" tabindex="-1" aria-labelledby="shining3d-organization-name-modal-Label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="shining3d-organization-name-modal-Label">Shining3d Organization Name</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <img src="{{ asset('public/assets/shining3d-organization-name.jpg') }}" alt="Precision Cuts Placement" class="img-fluid shadow-sm">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


{{-- shining3d-org-name-modal --}}
<div class="modal fade" id="shining3d-org-name-modal" tabindex="-1" aria-labelledby="shining3d-org-name-modal-Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="shining3d-org-name-modal-Label">
                    Update Shining3D Organization Name
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <h6 class="mb-0">
                    To fetch scans from Shining3D, please update your Shining3D Organization Name in your Profile Settings.
                </h6>
            </div>

            <div class="modal-footer">
                <a class="btn btn-primary" href="{{ route('profile-settings') }}">
                    Go to Profile Settings
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>



{{-- secret-blocks-modal --}}
<div class="modal fade" id="secret-blocks-modal" tabindex="-1" aria-labelledby="secret-blocks-modal-Label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="secret-blocks-modal-Label">SECRET Blocks</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <img src="{{ asset('public/assets/secret-blocks.webp') }}" alt="Precision Cuts Placement" class="img-fluid shadow-sm">
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

<div class="modal fade" id="changeExpiryDateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    Change Plan Expiry Date
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="changeExpiryDateForm" method="POST" action="{{ route('patients.changeExpiryDate') }}">
                    @csrf

                    <div class="mb-3">
                        <p>Are you sure you want to change this patient’s <strong>plan expiry date</strong>? This action cannot be undone.</p>
                    </div>

                    <input type="hidden" name="patient_id" id="modal_patient_id">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Patient Name</label>
                            <h5 id="modal_expiry_date_patient_name"></h5>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Current Expiry Date</label>
                            <h5>
                                <span id="modal_expiry_date_current_expiry_date"></span>
                            </h5>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Expiry Date</label>
                        <input type="date" class="form-control pickr" name="expiry_date" id="modal_expiry_date" required>
                        <span class="text-danger error-text expiry_date_error"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="modal_change_expiry_date_password" placeholder="Enter your password" required>
                        <span class="text-danger error-text change_expiry_date_password_error"></span>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" id="saveExpiryDate">Save</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="changeStatusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    Change Patient Status to "Shipped"
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="changePatientStatus" method="POST" action="{{ route('patients.change-patient-status') }}">
                    @csrf
                    <input type="hidden" name="patient_id" id="modal_change_status_patient_id">
                    <div class="mb-3">
                        <p>Are you sure you want to change this patient's status to <strong>"Shipped"</strong>? This action cannot be undone.</p>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Patient Name</label>
                            <h5 id="modal_change_status_patient_name"></h5>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Current Status</label>
                            <h5>
                                <span id="modal_change_status_current_status" class="badge"></span>
                            </h5>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Shipping Date</label>
                        <input type="date" class="form-control pickr" name="shipping_date" id="modal_change_status_shipping_date" value="{{ date('Y-m-d')}}" required>
                        <span class="text-danger error-text shipping_date_error"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="modal_change_status_password" placeholder="Please enter your password" required>
                        <span class="text-danger error-text password_error"></span>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" id="saveStatus">Change Status</button>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="changeCaseHolderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    Change Case Holder
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="changeCaseHolder" method="POST" action="{{ route('patients.change-case-holder') }}">
                    @csrf
                    <input type="hidden" name="patient_id" id="modal_change_case_holder_patient_id">
                    <div class="mb-3">
                        <p>Are you sure you want to change this patient's case holder?</p>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Patient Name</label>
                            <h5 id="modal_change_case_holder_patient_name"></h5>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Current Case Holder</label>
                            <h5>
                                <span id="modal_change_current_case_holder" class="badge"></span>
                            </h5>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label class="form-label">Select New Case Holder</label>
                        <select class="form-select" name="new_case_holder" id="modal_change_case_holder_new_case_holder" required>

                        </select>
                        <span class="text-danger error-text new_case_holder_error"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="modal_change_case_holder_password" placeholder="Please enter your password"  required>
                        <span class="text-danger error-text change_case_holder_password_error"></span>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" id="saveCaseHolder">Change Case Holder</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="changeTreatmentPlanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    Change Treatment Type
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="changeTreatmentPlan" method="POST" action="{{ route('patients.change-treatment-plan') }}">
                    @csrf
                    <input type="hidden" name="patient_id" id="modal_change_treatment_plan_patient_id">
                    <div id="modal_change_treatment_plan_show_error">

                    </div>
                    <div class="mb-3">
                        <p>Are you sure you want to change this patient's treatment plan?</p>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Patient Name</label>
                            <h5 id="modal_change_treatment_plan_patient_name"></h5>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">

                        <div class="row g-4">
                            <div class="col-12 col-md-6" style="height:580px">
                                <div class="plan-box d-flex flex-column justify-content-end modal_change_treatment_plan_div" data-selected="1" id="modal_change_treatment_plan_treatment" style="background-image: url('{{ asset('public') }}/assets/Treatment-Plan-Service-light.webp'); background-size: cover; background-position: center; " >

                                    <div style="border-radius: 10px; background-color: #80C6C7; padding: 15px; text-align: justify;height: 160px;">
                                        <div class="plan-title text-center text-white mb-2"  >Treatment Planning Service</div>
                                        <h4 class="page-title mb-0 font-size-18 text-justify" style="color:#209194;text-align:center">
                                            Precise Staging: From Patient's Scans to Print-Ready STL Files
                                        </h4>

                                        <!-- Centered Button -->
                                        <div class="d-flex justify-content-center mt-3">
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#serviceModal">
                                                Pricing Info
                                            </button>
                                        </div>
                                    </div>

                                    <input type="radio" name="modal_change_treatment_plan" class="d-none" value="1" >
                                </div>
                            </div>

                            <div class="col-12 col-md-6" style="height:580px">
                                <div class="plan-box d-flex flex-column justify-content-end modal_change_treatment_plan_div" data-selected="2" id="modal_change_treatment_plan_aligners" style="background-image: url('{{ asset('public') }}/assets/Aligners-light.webp'); background-size: cover; background-position: center; " >

                                    <div style="border-radius: 10px; background-color: #80C6C7; padding: 15px; text-align: justify; height: 160px;">
                                        <div class="plan-title text-center text-white mb-2" >Aligners Full-Service</div>
                                        <h4 class="page-title mb-0 font-size-18 text-justify" style="color:#209194;text-align:center">
                                            Digital Planning and Precision Production
                                        </h4>
                                    </div>

                                    <input type="radio" name="modal_change_treatment_plan" class="d-none" value="2" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="modal_change_treatment_plan_password" placeholder="Please enter your password"  required>
                        <span class="text-danger error-text change_treatment_plan_password_error"></span>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" id="saveChangeTreatmentType">Change Treatment Type</button>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="text-info-modal" tabindex="-1" aria-labelledby="text-info-title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="text-info-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <p id="text-info"></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
