var sideSelection2Context = {
    toothNumber: null,
    cutoutType: null
};


$(document).on('click', '.choose-tooth-section-2', function(){
    var toothNumber = $(this).attr('data-id');
    var dataImage = $(this).attr('data-image');
    var cutoutTypeSelected = $("input[name='class-selector-section-2']:checked"). val();
    var isMissingTooth = $(this).attr('data-section2-missing') === '1';

    // Keep missing/unerupted tooth hidden while allowing other element placements.
    if (!(isMissingTooth && cutoutTypeSelected !== 'unerupted-teeth')) {
        $(this).attr('src', baseUrl + '/public/assets/tooth/png/selected/'+ dataImage );
    }

    // Wrap the tooth in a wrapper for positioning overlays
    if (!$(this).parent().hasClass('tooth-wrapper')) {
        $(this).wrap('<div class="tooth-wrapper" style="position: relative; display: inline-block;"></div>');
    }

    // Store context and show modal
    sideSelection2Context.toothNumber = toothNumber;
    sideSelection2Context.cutoutType = cutoutTypeSelected;

    if(cutoutTypeSelected == "coil" ){
        coil(toothNumber);
    }
    if(cutoutTypeSelected == "unerupted-teeth"  ){
        uneruptedTeeth(toothNumber, 'lower');
        return;
    }

    if(cutoutTypeSelected == "extracted-teeth"  ){
        extractedTeeth(toothNumber);
    }
    if(cutoutTypeSelected == "tooth-movement-restrictions"  ){
        toothMovementRestrictions(toothNumber, 'lower');
        return;
    }

    if(cutoutTypeSelected == "pontic"  ){
        pontic(toothNumber);
    }
    if(cutoutTypeSelected == "bridge"  ){
        bridge(toothNumber);
        return;
    }
});


function getSection2ToothSide(toothNumber) {
    var toothNum = parseInt(toothNumber, 10);
    if (isNaN(toothNum)) {
        return null;
    }

    // 1-16: upper side, 17-32: lower side
    return (toothNum >= 1 && toothNum <= 16) ? 'upper' : 'lower';
}

function repositionSection2Overlays(wrapper, side) {
    var overlayOrder = [
        '.coil-overlay',
        '.extracted-overlay',
        '.movement-overlay',
        '.bridge-overlay'
    ];

    var overlays = [];
    $.each(overlayOrder, function(_, selector) {
        var el = wrapper.find(selector + '[data-side="' + side + '"]');
        if (el.length > 0) {
            overlays.push(el);
        }
    });

    var baseOffset = 16;
    var gap = 6;
    var cumulativeOffset = baseOffset;

    $.each(overlays, function(_, overlay) {
        var height = parseInt(overlay.css('height'), 10) || 20;

        if (side === 'upper') {
            overlay.css({ top: '-' + cumulativeOffset + 'px', bottom: '' });
        } else {
            overlay.css({ bottom: '-' + cumulativeOffset + 'px', top: '' });
        }

        cumulativeOffset += height + gap;
    });
}

function getSection2MaxOverflow(layoutWrapper, side) {
    var maxOverflow = 0;

    layoutWrapper.find('img.choose-tooth-section-2[data-id]').each(function() {
        var toothNum = parseInt($(this).attr('data-id'), 10);
        if (isNaN(toothNum)) {
            return;
        }

        var toothSide = getSection2ToothSide(toothNum);
        if (toothSide !== side) {
            return;
        }

        var wrapper = $(this).parent('.tooth-wrapper');
        if (wrapper.length === 0) {
            return;
        }

        wrapper.find('.section2-overlay[data-side="' + side + '"]').each(function() {
            var offsetProp = side === 'upper' ? 'top' : 'bottom';
            var offsetValue = parseFloat($(this).css(offsetProp));
            var height = $(this).outerHeight() || parseInt($(this).css('height'), 10) || 20;

            if (isNaN(offsetValue)) {
                return;
            }

            var overflow = Math.abs(offsetValue) + height;
            if (overflow > maxOverflow) {
                maxOverflow = overflow;
            }
        });
    });

    return maxOverflow;
}

function adjustSection2LayoutSpacing(tooth) {
    if (!tooth || tooth.length === 0) {
        return;
    }

    var layoutWrapper = tooth.closest('.teeth-layout-wrapper');
    if (layoutWrapper.length === 0) {
        return;
    }

    var upperArc = layoutWrapper.find('div#classIIUpperArcNew-2').first();
    var lowerArc = layoutWrapper.find('div#classIILowerArc-2').first();

    var baseUpperPadding = 30;
    var baseLowerPadding = 35;

    var requiredUpperPadding = Math.max(baseUpperPadding, getSection2MaxOverflow(layoutWrapper, 'upper') + 10);
    var requiredLowerPadding = Math.max(baseLowerPadding, getSection2MaxOverflow(layoutWrapper, 'lower') + 10);

    if (upperArc.length > 0) {
        upperArc[0].style.setProperty('padding-top', requiredUpperPadding + 'px', 'important');
    }
    if (lowerArc.length > 0) {
        lowerArc[0].style.setProperty('padding-bottom', requiredLowerPadding + 'px', 'important');
    }
}

function writeSection2FeatureInputs(featureValues) {
    $('input[name="feature_unerupted_teeth_ids"]').val(JSON.stringify(featureValues.uneruptedTeeth));
    $('input[name="feature_extracted_teethids"]').val(JSON.stringify(featureValues.extractedTeeth));
    $('input[name="feature_tooth_movement_restrictions_ids"]').val(JSON.stringify(featureValues.toothMovementRestrictions));
    $('input[name="feature_coil_ids"]').val(JSON.stringify(featureValues.coil));
    $('input[name="feature_pontic_ids"]').val(JSON.stringify(featureValues.pontic));
    $('input[name="feature_bridge_ids"]').val(JSON.stringify(featureValues.bridge));
}

function syncSection2FeatureInputs() {
    var featureValues = {
        uneruptedTeeth: [],
        extractedTeeth: [],
        toothMovementRestrictions: [],
        coil: [],
        pontic: [],
        bridge: []
    };

    $('img.choose-tooth-section-2[data-id]').each(function() {
        var tooth = $(this);
        var toothId = parseInt(tooth.attr('data-id'), 10);
        if (isNaN(toothId)) {
            return;
        }

        var wrapper = tooth.parent('.tooth-wrapper');
        if (tooth.attr('data-section2-missing') === '1') {
            featureValues.uneruptedTeeth.push(toothId);
        }

        if (wrapper.length > 0) {
            if (wrapper.find('.extracted-overlay').length > 0) {
                featureValues.extractedTeeth.push(toothId);
            }
            if (wrapper.find('.movement-overlay').length > 0) {
                featureValues.toothMovementRestrictions.push(toothId);
            }
            if (wrapper.find('.coil-overlay').length > 0) {
                featureValues.coil.push(toothId);
            }
            if (wrapper.find('.bridge-overlay').length > 0) {
                featureValues.bridge.push(toothId);
            }
        }

        if (tooth.attr('data-section2-special') === 'pontic') {
            featureValues.pontic.push(toothId);
        }
    });

    writeSection2FeatureInputs(featureValues);
}

function initSection2LayoutSpacing() {
    $('.teeth-layout-wrapper').each(function() {
        var firstTooth = $(this).find('img.choose-tooth-section-2').first();
        if (firstTooth.length > 0) {
            adjustSection2LayoutSpacing(firstTooth);
        }
    });

    syncSection2FeatureInputs();
}

function ensureCoilPonticBridgeModal() {
    if ($('#coilPonticBridgeModal').length > 0) {
        return;
    }

    var modalHtml = '' +
        '<div class="modal fade" id="coilPonticBridgeModal" tabindex="-1" role="dialog" aria-hidden="true">' +
            '<div class="modal-dialog modal-dialog-centered" role="document">' +
                '<div class="modal-content">' +
                    '<div class="modal-header">' +
                        '<h5 class="modal-title">Select Option</h5>' +
                        '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>' +
                    '</div>' +
                    '<div class="modal-body text-center">' +
                        '<p class="mb-3">Please choose one option for this tooth.</p>' +
                        '<div class="d-flex justify-content-center gap-2">' +
                            '<button type="button" class="btn btn-outline-primary" id="btn-coil-select-pontic">Pontic</button>' +
                            '<button type="button" class="btn btn-outline-primary" id="btn-coil-select-bridge">Bridge</button>' +
                            '<button type="button" class="btn btn-secondary" id="btn-coil-select-skip">Skip</button>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>' +
        '</div>';

    $('body').append(modalHtml);
}

function openCoilPonticBridgeModal(toothNumber) {
    ensureCoilPonticBridgeModal();
    $('#coilPonticBridgeModal').data('toothNumber', toothNumber).modal('show');
}

function refreshSection2ToothSelectedState(tooth) {
    if (!tooth || tooth.length === 0) {
        return;
    }

    var wrapper = tooth.parent('.tooth-wrapper');
    if (wrapper.length === 0) {
        return;
    }

    var isMissingTooth = tooth.attr('data-section2-missing') === '1';
    var specialOption = tooth.attr('data-section2-special') || '';

    if (isMissingTooth && specialOption !== 'pontic') {
        tooth.css('opacity', '0');
        adjustSection2LayoutSpacing(tooth);
        syncSection2FeatureInputs();
        return;
    }

    tooth.css('opacity', '');
    var hasOverlays = wrapper.find('.section2-overlay').length > 0;

    if (specialOption === 'pontic') {
        var ponticImage = tooth.attr('data-image');
        if (ponticImage) {
            tooth.attr('src', baseUrl + '/public/assets/tooth/coloured/' + ponticImage);
        }
    } else if (!hasOverlays) {
        var originalImage = tooth.attr('data-image');
        if (originalImage) {
            tooth.attr('src', baseUrl + '/public/assets/tooth/png/' + originalImage);
        }
    }

    adjustSection2LayoutSpacing(tooth);
    syncSection2FeatureInputs();
}

function setSection2MissingToothState(tooth, shouldHide) {
    if (!tooth || tooth.length === 0) {
        return;
    }

    if (shouldHide) {
        tooth.attr('data-section2-missing', '1');
        tooth.css('opacity', '0');
    } else {
        tooth.removeAttr('data-section2-missing');
        tooth.css('opacity', '');
    }

    refreshSection2ToothSelectedState(tooth);
}

function placeSection2Overlay(toothNumber, overlayClass, imagePath, width, height, altText) {
    var toothNum = parseInt(toothNumber, 10);
    if (isNaN(toothNum)) {
        return;
    }

    var tooth = $('img.choose-tooth-section-2[data-id="' + toothNumber + '"]');
    if (tooth.length === 0) {
        return;
    }

    var wrapper = tooth.parent('.tooth-wrapper');
    if (wrapper.length === 0) {
        return;
    }

    var side = getSection2ToothSide(toothNum);
    if (!side) {
        return;
    }

    var existingOverlay = wrapper.find('.' + overlayClass + '[data-side="' + side + '"]');
    if (existingOverlay.length > 0) {
        existingOverlay.remove();
        repositionSection2Overlays(wrapper, side);
        refreshSection2ToothSelectedState(tooth);
        return;
    }

    var overlayCss = {
        position: 'absolute',
        left: '50%',
        width: width + 'px',
        height: height + 'px',
        transform: 'translateX(-50%)',
        zIndex: 10,
        pointerEvents: 'none'
    };

    $('<img>', {
        class: 'section2-overlay ' + overlayClass,
        src: baseUrl + imagePath,
        alt: altText,
        'data-side': side,
        style: 'object-fit: contain;'
    }).css(overlayCss).appendTo(wrapper);

    repositionSection2Overlays(wrapper, side);
    refreshSection2ToothSelectedState(tooth);
}

$(document).ready(function() {
    initSection2LayoutSpacing();
    ensureCoilPonticBridgeModal();
});

$(document).on('click', '#btn-coil-select-pontic', function() {
    var modal = $('#coilPonticBridgeModal');
    var toothNumber = modal.data('toothNumber');
    if (toothNumber) {
        pontic(toothNumber);
    }
    modal.modal('hide');
});

$(document).on('click', '#btn-coil-select-bridge', function() {
    var modal = $('#coilPonticBridgeModal');
    var toothNumber = modal.data('toothNumber');
    if (toothNumber) {
        bridge(toothNumber);
    }
    modal.modal('hide');
});

$(document).on('click', '#btn-coil-select-skip', function() {
    $('#coilPonticBridgeModal').modal('hide');
});

function coil(toothNumber){
    placeSection2Overlay(
        toothNumber,
        'coil-overlay',
        '/public/assets/tooth/png/coil.png',
        50,
        24,
        'coil'
    );
}

function uneruptedTeeth(toothNumber){
    var tooth = $('img.choose-tooth-section-2[data-id="' + toothNumber + '"]');
    if (tooth.length === 0) {
        return;
    }

    var isMissingTooth = tooth.attr('data-section2-missing') === '1';
    setSection2MissingToothState(tooth, !isMissingTooth);

    if (!isMissingTooth) {
        openCoilPonticBridgeModal(toothNumber);
    }
}

function extractedTeeth(toothNumber){
    placeSection2Overlay(
        toothNumber,
        'extracted-overlay',
        '/public/assets/tooth/png/extracted.png',
        22,
        22,
        'extracted'
    );
}

function toothMovementRestrictions(toothNumber){
    placeSection2Overlay(
        toothNumber,
        'movement-overlay',
        '/public/assets/tooth/png/movement.png',
        22,
        22,
        'movement'
    );
}

function pontic(toothNumber){
    var tooth = $('img.choose-tooth-section-2[data-id="' + toothNumber + '"]');
    if (tooth.length === 0) {
        return;
    }

    var wrapper = tooth.parent('.tooth-wrapper');
    if (wrapper.length === 0) {
        return;
    }

    var currentSpecial = tooth.attr('data-section2-special') || '';
    if (currentSpecial === 'pontic') {
        tooth.removeAttr('data-section2-special');
        refreshSection2ToothSelectedState(tooth);
        return;
    }

    // Pontic and Bridge are mutually exclusive on a single tooth.
    wrapper.find('.bridge-overlay').remove();
    tooth.attr('data-section2-special', 'pontic');

    // Show coloured pontic image immediately (even if tooth is missing — pontic makes it visible).
    var ponticImage = tooth.attr('data-image');
    if (ponticImage) {
        tooth.css('opacity', '');
        tooth.attr('src', baseUrl + '/public/assets/tooth/coloured/' + ponticImage);
    }

    // Use shared state refresh to finalise spacing and sync inputs.
    refreshSection2ToothSelectedState(tooth);
}

function bridge(toothNumber){
    var tooth = $('img.choose-tooth-section-2[data-id="' + toothNumber + '"]');
    if (tooth.length === 0) {
        return;
    }

    var wrapper = tooth.parent('.tooth-wrapper');
    if (wrapper.length === 0) {
        return;
    }

    var side = getSection2ToothSide(toothNumber);
    if (!side) {
        return;
    }

    var currentSpecial = tooth.attr('data-section2-special') || '';
    var existingBridge = wrapper.find('.bridge-overlay[data-side="' + side + '"]');

    if (currentSpecial === 'bridge' && existingBridge.length > 0) {
        existingBridge.remove();
        tooth.removeAttr('data-section2-special');
        repositionSection2Overlays(wrapper, side);
        refreshSection2ToothSelectedState(tooth);
        return;
    }

    tooth.removeAttr('data-section2-special');
    wrapper.find('.bridge-overlay[data-side="' + side + '"]').remove();

    $('<img>', {
        class: 'section2-overlay bridge-overlay',
        src: baseUrl + '/public/assets/tooth/png/Bridge.png',
        alt: 'bridge',
        'data-side': side
    }).css({
        position: 'absolute',
        left: '50%',
        width: '44px',
        height: '24px',
        transform: 'translateX(-50%)',
        zIndex: 11,
        pointerEvents: 'none',
        objectFit: 'contain'
    }).appendTo(wrapper);

    tooth.attr('data-section2-special', 'bridge');
    repositionSection2Overlays(wrapper, side);
    refreshSection2ToothSelectedState(tooth);
}
