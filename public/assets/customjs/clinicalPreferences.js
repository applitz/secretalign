// ========================================== NEw Integrated Hook Orientation Logic ==========================================
// Store context for side selection modal
var sideSelectionContext = {
    toothNumber: null,
    cutoutType: null
};

var featureToothArrays = {
    button: { outer: [], inner: [] },
    iHook: { outer: [], inner: [] },
    precisionCut: { outer: [], inner: [] },
    biteTurbos: [],
    biteRamp: [],
    powerArmAttachment: { outer: [], inner: [] },
    powerRidge: { outer: [], inner: [] }
};

window.featureToothArrays = featureToothArrays;

function ensureClinicalPreferencesInfoModal() {
    if ($('#clinicalPreferencesInfoModal').length) {
        return;
    }

    $('body').append(
        '<div class="modal fade" id="clinicalPreferencesInfoModal" tabindex="-1" role="dialog" aria-hidden="true">' +
            '<div class="modal-dialog modal-dialog-centered" role="document">' +
                '<div class="modal-content">' +
                    '<div class="modal-header">' +
                        '<h5 class="modal-title">Invalid Action</h5>' +
                        '<button type="button" class="btn-close" data-bs-dismiss="modal"></button>' +
                    '</div>' +
                    '<div class="modal-body" id="clinicalPreferencesInfoModalBody"></div>' +
                    '<div class="modal-footer">' +
                        ' <button class="btn btn-primary" data-bs-dismiss="modal">Close</button>' +
                    '</div>' +
                '</div>' +
            '</div>' +
        '</div>'
    );
}

function showClinicalPreferencesInfoModal(message) {
    ensureClinicalPreferencesInfoModal();
    $('#clinicalPreferencesInfoModalBody').text(message || '');
    $('#clinicalPreferencesInfoModal').modal('show');
}

function writeFeatureArraysToHiddenInputs() {
    $('#feature_button_outer_ids').val(JSON.stringify(featureToothArrays.button.outer));
    $('#feature_button_inner_ids').val(JSON.stringify(featureToothArrays.button.inner));

    $('#feature_ihook_outer_ids').val(JSON.stringify(featureToothArrays.iHook.outer));
    $('#feature_ihook_inner_ids').val(JSON.stringify(featureToothArrays.iHook.inner));

    $('#feature_precision_cut_outer_ids').val(JSON.stringify(featureToothArrays.precisionCut.outer));
    $('#feature_precision_cut_inner_ids').val(JSON.stringify(featureToothArrays.precisionCut.inner));

    $('#feature_bite_turbos_ids').val(JSON.stringify(featureToothArrays.biteTurbos));
    $('#feature_bite_ramp_ids').val(JSON.stringify(featureToothArrays.biteRamp));

    $('#feature_power_arm_attachment_outer_ids').val(JSON.stringify(featureToothArrays.powerArmAttachment.outer));
    $('#feature_power_arm_attachment_inner_ids').val(JSON.stringify(featureToothArrays.powerArmAttachment.inner));

    $('#feature_power_ridge_outer_ids').val(JSON.stringify(featureToothArrays.powerRidge.outer));
    $('#feature_power_ridge_inner_ids').val(JSON.stringify(featureToothArrays.powerRidge.inner));
}

function syncFeatureToothArrays() {
    featureToothArrays.button.outer = [];
    featureToothArrays.button.inner = [];

    featureToothArrays.iHook.outer = [];
    featureToothArrays.iHook.inner = [];

    featureToothArrays.precisionCut.outer = [];
    featureToothArrays.precisionCut.inner = [];

    featureToothArrays.biteTurbos = [];
    featureToothArrays.biteRamp = [];

    featureToothArrays.powerArmAttachment.outer = [];
    featureToothArrays.powerArmAttachment.inner = [];

    featureToothArrays.powerRidge.outer = [];
    featureToothArrays.powerRidge.inner = [];

    $('img.choose-tooth[data-id]').each(function() {
        var toothId = parseInt($(this).attr('data-id'), 10);
        if (isNaN(toothId)) {
            return;
        }

        var wrapper = $(this).parent('.tooth-wrapper');
        if (wrapper.length === 0) {
            return;
        }

        if (wrapper.find('.button-overlay[data-side="upper"]').length > 0) featureToothArrays.button.outer.push(toothId);
        if (wrapper.find('.button-overlay[data-side="lower"]').length > 0) featureToothArrays.button.inner.push(toothId);

        if (wrapper.find('.i-hook-overlay[data-side="upper"]').length > 0) featureToothArrays.iHook.outer.push(toothId);
        if (wrapper.find('.i-hook-overlay[data-side="lower"]').length > 0) featureToothArrays.iHook.inner.push(toothId);

        if (wrapper.find('.precision-overlay[data-side="upper"]').length > 0) featureToothArrays.precisionCut.outer.push(toothId);
        if (wrapper.find('.precision-overlay[data-side="lower"]').length > 0) featureToothArrays.precisionCut.inner.push(toothId);

        if (wrapper.find('.bite-turbos-overlay').length > 0) featureToothArrays.biteTurbos.push(toothId);
        if (wrapper.find('.bite-ramp-overlay').length > 0) featureToothArrays.biteRamp.push(toothId);

        if (wrapper.find('.power-arm-attachment-overlay[data-side="upper"]').length > 0) featureToothArrays.powerArmAttachment.outer.push(toothId);
        if (wrapper.find('.power-arm-attachment-overlay[data-side="lower"]').length > 0) featureToothArrays.powerArmAttachment.inner.push(toothId);

        if (wrapper.find('.power-ridge-overlay[data-side="upper"]').length > 0) featureToothArrays.powerRidge.outer.push(toothId);
        if (wrapper.find('.power-ridge-overlay[data-side="lower"]').length > 0) featureToothArrays.powerRidge.inner.push(toothId);
    });

    writeFeatureArraysToHiddenInputs();
}



$(document).on('click', '.choose-tooth', function(){

    var toothNumber = $(this).attr('data-id');
    var dataImage = $(this).attr('data-image');
    var cutoutTypeSelected = $("input[name='class-selector']:checked"). val();

    // Change tooth image to selected version
    $(this).attr('src', baseUrl + '/public/assets/tooth/png/selected/'+ dataImage );

    // Wrap the tooth in a wrapper for positioning overlays
    if (!$(this).parent().hasClass('tooth-wrapper')) {
        $(this).wrap('<div class="tooth-wrapper" style="position: relative; display: inline-block;"></div>');
    }

    // Store context and show modal
    sideSelectionContext.toothNumber = toothNumber;
    sideSelectionContext.cutoutType = cutoutTypeSelected;

    if(cutoutTypeSelected == "button-cutout" || cutoutTypeSelected == "precision-cut" || cutoutTypeSelected == "i-hook" || cutoutTypeSelected == "power-ridge" || cutoutTypeSelected == "power-arm-attachment"){
        $('#sideSelectionModal').modal('show');
    }
    if(cutoutTypeSelected == "bite-ramp"  ){
        biteRamp(toothNumber);
    }
    if(cutoutTypeSelected == "bite-turbos"  ){
        biteTurbos(toothNumber, 'lower');
        return;
    }
});

// Handle upper side selection
$(document).on('click', '#btn-select-outer', function(){
    handleSideSelection('upper');
});

// Handle lower side selection
$(document).on('click', '#btn-select-inner', function(){
    handleSideSelection('lower');
});

// If modal closes without placing any element, restore tooth image if needed.
$(document).on('hidden.bs.modal', '#sideSelectionModal', function() {
    if (!sideSelectionContext.toothNumber) {
        return;
    }
    refreshToothSelectedState(sideSelectionContext.toothNumber);
    sideSelectionContext = { toothNumber: null, cutoutType: null };
});

function setToothSide(toothNumber) {
    var num = parseInt(toothNumber, 10);
    if (isNaN(num)) {
        return null;
    }

    if (num >= 1 && num <= 8) {
        return 'R';
    } else if (num >= 9 && num <= 16) {
        return 'L';
    } else if (num >= 17 && num <= 24) {
        return 'R';
    } else if (num >= 25 && num <= 32) {
        return 'L';
    }

    return null;
}
function handleSideSelection(side) {
    var toothNumber = sideSelectionContext.toothNumber;
    var cutoutType = sideSelectionContext.cutoutType;

    if (!toothNumber || !cutoutType) {
        return;
    }

    // Close modal
    $('#sideSelectionModal').modal('hide');

    // Execute the appropriate function with side info
    if(cutoutType == "button-cutout"){
        toggleButton(toothNumber, side);
    }
    else if(cutoutType == "precision-cut"){
        precisionCut(toothNumber, side);
    }
    else if(cutoutType == "i-hook"){
        iHook(toothNumber, side);
    }
    else if(cutoutType == "power-ridge"){
        powerRidge(toothNumber, side);
    }
    else if(cutoutType == "power-arm-attachment"){
        powerArmAttachment(toothNumber, side);
    }
    else if(cutoutType == "bite-ramp"){
        biteRamp(toothNumber, side);
    }
    else if(cutoutType == "bite-turbos"){
        biteTurbos(toothNumber, side);
    }

    // Reset context
    sideSelectionContext = { toothNumber: null, cutoutType: null };
}

function removeOtherCutouts(toothNumber, side, currentType) {
    var wrapper = $('img[data-id="' + toothNumber + '"]').parent('.tooth-wrapper');

    // Remove other primary cutouts on this side
    if (currentType === 'button-cutout') {
        wrapper.find('.precision-overlay[data-side="' + side + '"], .i-hook-overlay[data-side="' + side + '"]').remove();
    } else if (currentType === 'precision-cut') {
        wrapper.find('.button-overlay[data-side="' + side + '"], .i-hook-overlay[data-side="' + side + '"]').remove();
    } else if (currentType === 'i-hook') {
        wrapper.find('.button-overlay[data-side="' + side + '"], .precision-overlay[data-side="' + side + '"]').remove();
    }
}

function refreshToothSelectedState(toothNumber) {
    var tooth = $('img.choose-tooth[data-id="' + toothNumber + '"]');
    if (tooth.length === 0) {
        return;
    }

    var wrapper = tooth.parent('.tooth-wrapper');
    var hasOverlays = wrapper.find('.button-overlay, .precision-overlay, .i-hook-overlay, .power-ridge-overlay, .power-arm-attachment-overlay, .bite-ramp-overlay, .bite-turbos-overlay').length > 0;

    if (!hasOverlays) {
        var originalImage = tooth.attr('data-image');
        if (originalImage) {
            tooth.attr('src', baseUrl + '/public/assets/tooth/png/' + originalImage);
        }
    }

    syncFeatureToothArrays();
}

$(document).ready(function() {
    syncFeatureToothArrays();
    updateArcPadding();
});

function repositionOverlays(toothNumber, side) {
    var wrapper = $('img[data-id="' + toothNumber + '"]').parent('.tooth-wrapper');
    var overlays = [];

    wrapper.find('[data-side="' + side + '"]').each(function() {
        var $el = $(this);
        var type, height;
        if ($el.hasClass('power-arm-attachment-overlay')) {
            type = 'power-arm';
            height = 25;
        } else if ($el.hasClass('button-overlay') || $el.hasClass('precision-overlay') || $el.hasClass('i-hook-overlay')) {
            type = 'primary';
            height = 20;
        } else if ($el.hasClass('power-ridge-overlay')) {
            type = 'power-ridge';
            // Keep icon size same, but reserve extra vertical space around it.
            height = 30;
        }
        overlays.push({el: $el, type: type, height: height});
    });

    // Keep visual top-to-bottom order configurable per side.
    // side === 'upper' (Outer): top->bottom should be primary, power-arm, power-ridge.
    // Because upper overlays are placed upward with decreasing negative top values,
    // we sort in the reverse (near-tooth -> far) sequence to get that final visual order.
    // side !== 'upper' (Inner): top->bottom should be power-ridge, power-arm, primary.
    overlays.sort(function(a, b) {
        var orderUpper = {'power-ridge': 1, 'power-arm': 2, 'primary': 3};
        var orderLower = {'power-ridge': 1, 'power-arm': 2, 'primary': 3};
        var activeOrder = (side === 'upper') ? orderUpper : orderLower;
        return activeOrder[a.type] - activeOrder[b.type];
    });
    if(toothNumber >= 1 && toothNumber <= 16){
        if (side === 'upper') {
        var y = -25;
            overlays.forEach(function(ov) {
                ov.el.css({'top': y + 'px', 'bottom': ''});
                y -= ov.height + 5;
            });
        } else {
            var y = -25;
            overlays.forEach(function(ov) {
                ov.el.css({'bottom': y + 'px', 'top': ''});
                y -= ov.height + 5;
            });
        }
    } else {
        if (side === 'upper') {
            var y = -25;
            overlays.forEach(function(ov) {
                ov.el.css({'bottom': y + 'px', 'top': ''});
                y -= ov.height + 5;
            });
        } else {
            var y = -25;
            overlays.forEach(function(ov) {
                ov.el.css({'top': y + 'px', 'bottom': ''});
                y -= ov.height + 5;
            });
        }
    }


    updateArcPadding();
}

// Dynamically expand arc container padding so overlays never escape
// upward into .attachment-inline or downward outside the lower arc.
function updateArcPadding() {
    var buffer = 10;

    // Returns the pixel distance that the topmost stacked overlay extends
    // beyond the tooth-wrapper edge (mirrors the y calculation in repositionOverlays).
    function getMaxExtent(arcSelector, side) {
        var max = 0;
        $(arcSelector + ' .tooth-wrapper').each(function() {
            var overlays = $(this).find('[data-side="' + side + '"]');
            if (overlays.length === 0) return;
            var y = -25;
            var lastH = 20;
            overlays.each(function() {
                if ($(this).hasClass('power-arm-attachment-overlay')) {
                    lastH = 25;
                } else if ($(this).hasClass('power-ridge-overlay')) {
                    lastH = 30;
                } else {
                    lastH = 20;
                }
                y -= lastH + 5;
            });
            // The last overlay was placed at: y_after_loop + lastH + 5
            var topmostTop = Math.abs(y + lastH + 5);
            if (topmostTop > max) max = topmostTop;
        });
        return max;
    }

    var upperEl = document.getElementById('classIIUpperArcNew');
    var lowerEl = document.getElementById('classIILowerArc');
    if (!upperEl || !lowerEl) return;

    // 'upper' side overlays on upper arc → expand padding-top so they stay inside
    var extUpperTop = getMaxExtent('#classIIUpperArcNew', 'upper');
    upperEl.style.setProperty('padding-top', (extUpperTop > 0 ? extUpperTop + buffer : 30) + 'px', 'important');

    // 'lower' side overlays on upper arc → expand padding-bottom (space toward center)
    var extUpperBottom = getMaxExtent('#classIIUpperArcNew', 'lower');
    upperEl.style.setProperty('padding-bottom', (extUpperBottom > 0 ? extUpperBottom + buffer : 0) + 'px', 'important');

    // 'upper' side overlays on lower arc → uses bottom positioning for teeth 17-32, so expand padding-bottom
    var extLowerTop = getMaxExtent('#classIILowerArc', 'upper');
    lowerEl.style.setProperty('padding-bottom', (extLowerTop > 0 ? extLowerTop + buffer : 35) + 'px', 'important');

    // 'lower' side overlays on lower arc → uses top positioning for teeth 17-32, so expand padding-top
    var extLowerBottom = getMaxExtent('#classIILowerArc', 'lower');
    lowerEl.style.setProperty('padding-top', (extLowerBottom > 0 ? extLowerBottom + buffer : 0) + 'px', 'important');
}

function buttonCutout(toothNumber, side){
    // Toggle the button image on the selected tooth
    toggleButton(toothNumber, side);
}

function toggleButton(toothNumber, side) {
    // Remove other cutouts from this position first
    removeOtherCutouts(toothNumber, side, 'button-cutout');

    var wrapper = $('img[data-id="' + toothNumber + '"]').parent('.tooth-wrapper');

    var existingButton = wrapper.find('.button-overlay[data-side="' + side + '"]');

    // Toggle: remove if exists, add if doesn't
    if (existingButton.length > 0) {
        existingButton.remove();
    } else {
        var buttonImg = $('<img src="' + baseUrl + '/public/assets/tooth/png/buttons.webp" class="button-overlay" data-side="' + side + '" style="position: absolute; width: 20px; height: 20px; left: 50%; transform: translateX(-50%); z-index: 10;">');
        wrapper.append(buttonImg);
    }

    repositionOverlays(toothNumber, side);
    refreshToothSelectedState(toothNumber);
}

function getPrecisionCutImageSrc(toothNumber, side) {
    var toothSide = setToothSide(toothNumber);
    if (!toothSide) {
        return baseUrl + '/public/assets/tooth/png/precisioncut.webp';
    }
    if(toothNumber >= 1 && toothNumber <= 16){
        if(side === 'upper'){
            return baseUrl + '/public/assets/tooth/png/precisioncut-U' + toothSide + '.webp';
        } else {
            return baseUrl + '/public/assets/tooth/png/precisioncut-L' + toothSide + '.webp';
        }
    } else {
        if(side === 'upper'){
            return baseUrl + '/public/assets/tooth/png/precisioncut-L' + toothSide + '.webp';
        } else {
            return baseUrl + '/public/assets/tooth/png/precisioncut-U' + toothSide + '.webp';
        }
    }

}

function precisionCut(toothNumber, side){
    // Remove other cutouts from this position first
    removeOtherCutouts(toothNumber, side, 'precision-cut');

    var wrapper = $('img[data-id="' + toothNumber + '"]').parent('.tooth-wrapper');

    var existing = wrapper.find('.precision-overlay[data-side="' + side + '"]');

    // Toggle: remove if exists, add if doesn't
    if (existing.length > 0) {
        existing.remove();
    } else {
        var img = $('<img src="' + getPrecisionCutImageSrc(toothNumber, side) + '" class="precision-overlay" data-side="' + side + '" style="position: absolute; width: 20px; height: 20px; left: 50%; transform: translateX(-50%); z-index: 10;">');
        wrapper.append(img);
    }

    repositionOverlays(toothNumber, side);
    refreshToothSelectedState(toothNumber);
}

function getIHookImageSrc(toothNumber, side) {
    var toothSide = setToothSide(toothNumber);

    if (!toothSide) {
        return baseUrl + '/public/assets/tooth/png/I-hook.webp';
    }
    if(toothNumber >= 1 && toothNumber <= 16){
        if(side === 'upper'){
            return baseUrl + '/public/assets/tooth/png/I-hook-U' + toothSide + '.webp';
        } else {
            return baseUrl + '/public/assets/tooth/png/I-hook-L' + toothSide + '.webp';
        }
    } else {
        if(side === 'upper'){
            return baseUrl + '/public/assets/tooth/png/I-hook-L' + toothSide + '.webp';
        } else {
            return baseUrl + '/public/assets/tooth/png/I-hook-U' + toothSide + '.webp';
        }
    }
}

function iHook(toothNumber, side){
    // Remove other cutouts from this position first
    removeOtherCutouts(toothNumber, side, 'i-hook');

    var wrapper = $('img[data-id="' + toothNumber + '"]').parent('.tooth-wrapper');

    var existing = wrapper.find('.i-hook-overlay[data-side="' + side + '"]');

    // Toggle: remove if exists, add if doesn't
    if (existing.length > 0) {
        existing.remove();
    } else {
        var img = $('<img src="' + getIHookImageSrc(toothNumber, side) + '" class="i-hook-overlay" data-side="' + side + '" style="position: absolute; width: 20px; height: 20px; left: 50%; transform: translateX(-50%); z-index: 10;">');
        wrapper.append(img);
    }

    repositionOverlays(toothNumber, side);
    refreshToothSelectedState(toothNumber);
}

function powerRidge(toothNumber, side){
    var wrapper = $('img[data-id="' + toothNumber + '"]').parent('.tooth-wrapper');

    var existing = wrapper.find('.power-ridge-overlay[data-side="' + side + '"]');

    // Toggle: remove if exists, add if doesn't
    if (existing.length > 0) {
        existing.remove();
    } else {
        var img = $('<img src="' + baseUrl + '/public/assets/tooth/png/Power-Ridge.webp" class="power-ridge-overlay" data-side="' + side + '" style="position: absolute; width: 30px; height: 20px; left: 50%; transform: translateX(-50%); z-index: 12;">');
        wrapper.append(img);
    }

    repositionOverlays(toothNumber, side);
    refreshToothSelectedState(toothNumber);
}
function powerArmAttachment(toothNumber, side){
    var wrapper = $('img[data-id="' + toothNumber + '"]').parent('.tooth-wrapper');

    var existing = wrapper.find('.power-arm-attachment-overlay[data-side="' + side + '"]');

    if (existing.length > 0) {
        existing.remove();
    } else {
        if(toothNumber >= 1 && toothNumber <= 16){
            var imgSrc = side === 'upper' ? baseUrl + '/public/assets/tooth/png/Power-Arm-Attachment.webp' : baseUrl + '/public/assets/tooth/png/Power-Arm-Attachment-lower.webp';
        } else {
            var imgSrc = side === 'upper' ? baseUrl + '/public/assets/tooth/png/Power-Arm-Attachment-lower.webp' : baseUrl + '/public/assets/tooth/png/Power-Arm-Attachment.webp';
        }
        var img = $('<img src="' + imgSrc + '" class="power-arm-attachment-overlay" data-side="' + side + '" style="position: absolute; width: 15px; height: 25px; left: 50%; transform: translateX(-50%); z-index: 11;">');
        wrapper.append(img);
    }

    repositionOverlays(toothNumber, side);
    refreshToothSelectedState(toothNumber);
}
function biteRamp(toothNumber, side){
    var upperTeeth = [6, 7, 8, 9, 10, 11];
    var lowerTeeth = [22, 23, 24, 25, 26, 27];
    var toothNum = parseInt(toothNumber, 10);
    var imgSrc = '';

    if (upperTeeth.indexOf(toothNum) !== -1) {
        imgSrc = baseUrl + '/public/assets/tooth/png/Bite-Ramp.webp';
    } else if (lowerTeeth.indexOf(toothNum) !== -1) {
        imgSrc = baseUrl + '/public/assets/tooth/png/Bite-Ramp-lower.webp';
    } else {
        showClinicalPreferencesInfoModal('Bite Ramp is only possible on teeth 1, 2, and 3.');
        refreshToothSelectedState(toothNumber);
        return;
    }

    var wrapper = $('img[data-id="' + toothNumber + '"]').parent('.tooth-wrapper');
    var existing = wrapper.find('.bite-ramp-overlay');

    // Toggle on/off on the same tooth.
    if (existing.length > 0) {
        existing.remove();
        refreshToothSelectedState(toothNumber);
        return;
    }

    var img = $('<img src="' + imgSrc + '" class="bite-ramp-overlay" style="position: absolute; width: 30px; height: 30px; left: 50%; top: 50%; transform: translate(-50%, -50%); z-index: 13; pointer-events: none;">');
    wrapper.append(img);
    refreshToothSelectedState(toothNumber);
}
function biteTurbos(toothNumber, side){
    var allowedTeeth = [1, 2, 3, 4, 5, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 28, 29, 30, 31, 32];
    var toothNum = parseInt(toothNumber, 10);

    if (allowedTeeth.indexOf(toothNum) === -1) {
        showClinicalPreferencesInfoModal('Bite Turbo is only possible on teeth 4, 5, 6, 7 and 8.');
        refreshToothSelectedState(toothNumber);
        return;
    }

    var wrapper = $('img[data-id="' + toothNumber + '"]').parent('.tooth-wrapper');
    var existing = wrapper.find('.bite-turbos-overlay');

    // Toggle on/off on the same tooth.
    if (existing.length > 0) {
        existing.remove();
        refreshToothSelectedState(toothNumber);
        return;
    }

    var img = $('<img src="' + baseUrl + '/public/assets/tooth/png/Bite-Turbos.webp" class="bite-turbos-overlay" style="position: absolute; width: 35px; height: 30px; left: 50%; top: 50%; transform: translate(-50%, -50%); z-index: 13; pointer-events: none;">');
    wrapper.append(img);
    refreshToothSelectedState(toothNumber);
}
