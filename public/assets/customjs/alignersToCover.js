var sideAlignersToCoverContext = {
    minimumTeeth: 4,
    animationStepMs: 70,
    ur: {
        startToothId: null,
        endToothId: null,
        lastToothId: null,
    },
    ul: {
        startToothId: null,
        endToothId: null,
        lastToothId: null,
    },
    lr: {
        startToothId: null,
        endToothId: null,
        lastToothId: null,
    },
    ll: {
        startToothId: null,
        endToothId: null,
        lastToothId: null,
    },
    upper: {
        pendingAnimationTimeouts: [],
        animationRunId: 0,
        suppressNextAnimation: false,
    },
    lower: {
        pendingAnimationTimeouts: [],
        animationRunId: 0,
        suppressNextAnimation: false,
    },
};

function getAlignersToCoverArch(toothId) {
    return toothId <= 16 ? 'upper' : 'lower';
}

function getAlignersToCoverSide(toothId) {
    if (toothId >= 1 && toothId <= 8) {
        return 'ur';
    }

    if (toothId >= 9 && toothId <= 16) {
        return 'ul';
    }

    if (toothId >= 17 && toothId <= 24) {
        return 'lr';
    }

    return 'll';
}

function getAlignersToCoverArchFromSide(sideName) {
    return sideName === 'ur' || sideName === 'ul' ? 'upper' : 'lower';
}

function getAlignersToCoverContainerSelector(arch) {
    return arch === 'upper' ? '#classIIUpperArcNew-3' : '#classIILowerArc-3';
}

function getAlignersToCoverSummarySelector(arch) {
    return '#aligners-to-cover-' + arch + '-summary';
}

function getAlignersToCoverStateInputId(stateName) {
    return '#' + stateName + '_state';
}

function getAlignersToCoverStateNameFromSide(sideName) {
    return 'tla_' + sideName;
}

function getAlignersToCoverLabel(toothId) {
    var imageName = $('.choose-tooth-aligners-to-cover[data-id="' + toothId + '"]').attr('data-image') || '';
    return imageName.replace('.png', '');
}

function getAlignersToCoverDefaultImageSrc($image) {
    var cachedSrc = $image.attr('data-default-src');
    var normalizedSrc;

    if (cachedSrc) {
        normalizedSrc = cachedSrc
            .replace('/tooth/coloured/', '/tooth/png/')
            .replace('tooth/coloured/', 'tooth/png/');

        if (normalizedSrc !== cachedSrc) {
            $image.attr('data-default-src', normalizedSrc);
        }

        return normalizedSrc;
    }

    normalizedSrc = ($image.attr('src') || '')
        .replace('/tooth/coloured/', '/tooth/png/')
        .replace('tooth/coloured/', 'tooth/png/');

    $image.attr('data-default-src', normalizedSrc);
    return normalizedSrc;
}

function getAlignersToCoverColoredImageSrc($image) {
    return getAlignersToCoverDefaultImageSrc($image)
        .replace('/tooth/png/', '/tooth/coloured/')
        .replace('tooth/png/', 'tooth/coloured/');
}

function getAlignersToCoverToothBasePath($image) {
    var src = $image.attr('src') || '';
    var fallbackSrc;
    var match = src.match(/^(.*\/public\/assets\/tooth)\/(png|coloured)\//);

    if (match && match[1]) {
        return match[1];
    }

    fallbackSrc = $('.choose-tooth-aligners-to-cover').first().attr('src') || '';
    match = fallbackSrc.match(/^(.*\/public\/assets\/tooth)\/(png|coloured)\//);

    if (match && match[1]) {
        return match[1];
    }

    return 'public/assets/tooth';
}

function getAlignersToCoverImageSrcByState($image, isSelected) {
    var imageName = ($image.attr('data-image') || '').trim();
    var defaultSrc = getAlignersToCoverDefaultImageSrc($image);
    var folderName = isSelected ? 'coloured' : 'png';
    var basePath;

    if (!imageName) {
        return isSelected ? getAlignersToCoverColoredImageSrc($image) : defaultSrc;
    }

    basePath = getAlignersToCoverToothBasePath($image);
    return basePath + '/' + folderName + '/' + imageName;
}

function updateAlignersToCoverImageState(toothId, isSelected) {
    var $image = $('.choose-tooth-aligners-to-cover[data-id="' + toothId + '"]');

    if (!$image.length) {
        return;
    }

    $image.attr('src', getAlignersToCoverImageSrcByState($image, isSelected));
}

function getAlignersToCoverStateMeta(toothId) {
    if (toothId >= 1 && toothId <= 8) {
        return {
            name: 'tla_ur',
            number: 9 - toothId,
        };
    }

    if (toothId >= 9 && toothId <= 16) {
        return {
            name: 'tla_ul',
            number: toothId - 8,
        };
    }

    if (toothId >= 17 && toothId <= 24) {
        return {
            name: 'tla_lr',
            number: 25 - toothId,
        };
    }

    return {
        name: 'tla_ll',
        number: toothId - 24,
    };
}

function getAlignersToCoverToothIdFromState(name, number) {
    if (name === 'tla_ur') {
        return 9 - number;
    }

    if (name === 'tla_ul') {
        return number + 8;
    }

    if (name === 'tla_lr') {
        return 25 - number;
    }

    if (name === 'tla_ll') {
        return number + 24;
    }

    return null;
}

function getAlignersToCoverRangeLength(startToothId, endToothId) {
    return Math.abs(endToothId - startToothId) + 1;
}

function getAlignersToCoverSideNamesByArch(arch) {
    return arch === 'upper' ? ['ur', 'ul'] : ['lr', 'll'];
}

function getAlignersToCoverToothIdsFromRange(startToothId, endToothId) {
    var toothIds = [];
    var normalizedStart = Math.min(startToothId, endToothId);
    var normalizedEnd = Math.max(startToothId, endToothId);
    var toothId;

    for (toothId = normalizedStart; toothId <= normalizedEnd; toothId++) {
        toothIds.push(toothId);
    }

    return toothIds;
}

function getAlignersToCoverSideBounds(sideName) {
    if (sideName === 'ur') {
        return { startToothId: 1, endToothId: 8 };
    }

    if (sideName === 'ul') {
        return { startToothId: 9, endToothId: 16 };
    }

    if (sideName === 'lr') {
        return { startToothId: 17, endToothId: 24 };
    }

    return { startToothId: 25, endToothId: 32 };
}

function getAlignersToCoverAnchoredRangeFromLastTooth(toothId) {
    if (toothId >= 1 && toothId <= 8) {
        return {
            startToothId: toothId,
            endToothId: 8,
        };
    }

    if (toothId >= 9 && toothId <= 16) {
        return {
            startToothId: 9,
            endToothId: toothId,
        };
    }

    if (toothId >= 17 && toothId <= 24) {
        return {
            startToothId: toothId,
            endToothId: 24,
        };
    }

    return {
        startToothId: 25,
        endToothId: toothId,
    };
}

function getAlignersToCoverLastToothIdFromRange(startToothId, endToothId) {
    if (endToothId <= 8) {
        return Math.min(startToothId, endToothId);
    }

    if (startToothId >= 9 && endToothId <= 16) {
        return Math.max(startToothId, endToothId);
    }

    if (startToothId >= 17 && endToothId <= 24) {
        return Math.min(startToothId, endToothId);
    }

    if (startToothId >= 25) {
        return Math.max(startToothId, endToothId);
    }

    return startToothId;
}

function getAlignersToCoverToothIdsBySide(sideName) {
    var sideContext = sideAlignersToCoverContext[sideName];

    if (!sideContext || sideContext.startToothId === null || sideContext.endToothId === null) {
        return [];
    }

    return getAlignersToCoverToothIdsFromRange(sideContext.startToothId, sideContext.endToothId);
}

function getAlignersToCoverAnimationToothIdsForSide(sideName) {
    var toothIds = getAlignersToCoverToothIdsBySide(sideName).slice();

    if (sideName === 'ul' || sideName === 'll') {
        toothIds.reverse();
    }

    return toothIds;
}

function ensureAlignersToCoverUi() {
    if (!$('#aligners-to-cover-styles').length) {
        $('head').append([
            '<style id="aligners-to-cover-styles">',
            '.aligners-to-cover-summary{margin-top:12px;font-size:14px;font-weight:500;color:#334155;text-align:center;}',
            '</style>'
        ].join(''));
    }

    if (!$('#aligners-to-cover-upper-summary').length) {
        $('#classIIUpperArcNew-3').after('<div id="aligners-to-cover-upper-summary" class="aligners-to-cover-summary"></div>');
    }

    if (!$('#aligners-to-cover-lower-summary').length) {
        $('#classIILowerArc-3').after('<div id="aligners-to-cover-lower-summary" class="aligners-to-cover-summary"></div>');
    }
}

function ensureAlignersToCoverStateInputs() {
    var stateNames = ['tla_ur', 'tla_ul', 'tla_lr', 'tla_ll'];

    $.each(stateNames, function(_, stateName) {
        var selector = getAlignersToCoverStateInputId(stateName);
        var archId = stateName.replace('tla_', '');

        if (!$(selector).length) {
            $('body').append('<input type="hidden" id="' + stateName + '_state" data-id="' + archId + '" value="[]">');
        }
    });
}

function resetAlignersToCoverArchImages(arch) {
    $(getAlignersToCoverContainerSelector(arch)).find('.choose-tooth-aligners-to-cover').each(function() {
        $(this).removeAttr('data-default-src');
        updateAlignersToCoverImageState($(this).attr('data-id'), false);
    });
}

function clearAlignersToCoverArchAnimation(arch) {
    var archContext = sideAlignersToCoverContext[arch];

    $.each(archContext.pendingAnimationTimeouts || [], function(_, timeoutId) {
        clearTimeout(timeoutId);
    });

    archContext.pendingAnimationTimeouts = [];
}

function getNextAlignersToCoverAnimationRunId(arch) {
    var archContext = sideAlignersToCoverContext[arch];
    archContext.animationRunId += 1;
    return archContext.animationRunId;
}

function animateAlignersToCoverRange(arch, toothIds) {
    var archContext = sideAlignersToCoverContext[arch];
    var runId = archContext.animationRunId;
    var stepMs = sideAlignersToCoverContext.animationStepMs;
    var sequenceIndex = 0;
    var index;

    for (index = 0; index < toothIds.length; index++) {
        (function(currentToothId, delayMs) {
            var timeoutId = setTimeout(function() {
                if (archContext.animationRunId !== runId) {
                    return;
                }

                updateAlignersToCoverImageState(currentToothId, true);
            }, delayMs);

            archContext.pendingAnimationTimeouts.push(timeoutId);
        })(toothIds[index], sequenceIndex * stepMs);

        sequenceIndex += 1;
    }
}

function getAlignersToCoverEmptyState() {
    return {
        tla_ur: [],
        tla_ul: [],
        tla_lr: [],
        tla_ll: [],
    };
}

function addAlignersToCoverToothInState(state, toothId) {
    var stateMeta = getAlignersToCoverStateMeta(toothId);

    state[stateMeta.name].push(stateMeta.number);
}

function sortAlignersToCoverStateNumbers(state) {
    $.each(state, function(stateName) {
        state[stateName].sort(function(a, b) {
            return a - b;
        });
    });
}

function syncAlignersToCoverStateInputs() {
    var combinedState = getAlignersToCoverEmptyState();
    var sideNames = ['ur', 'ul', 'lr', 'll'];
    var allSelectedTeethIds = [];
    var stateNameBySide = {
        ur: 'tla_ur',
        ul: 'tla_ul',
        lr: 'tla_lr',
        ll: 'tla_ll',
    };

    $.each(sideNames, function(_, sideName) {
        var toothIds = getAlignersToCoverToothIdsBySide(sideName);
        var stateName = stateNameBySide[sideName];
        var stateNumbers = [];

        $.each(toothIds, function(__, toothId) {
            var stateMeta = getAlignersToCoverStateMeta(toothId);
            stateNumbers.push(stateMeta.number);
            allSelectedTeethIds.push(toothId);
        });

        stateNumbers.sort(function(a, b) {
            return a - b;
        });
        combinedState[stateName] = stateNumbers;
    });

    allSelectedTeethIds.sort(function(a, b) {
        return a - b;
    });

    $.each(combinedState, function(stateName, values) {
        var $input = $(getAlignersToCoverStateInputId(stateName));
        $input.val(JSON.stringify(values));
        $input.attr('data-selected-teeth', allSelectedTeethIds.join(','));
    });

    $('#aligners_to_cover').val(allSelectedTeethIds.join(','));
}

function clearAlignersToCoverArchSelection(arch) {
    $.each(getAlignersToCoverSideNamesByArch(arch), function(_, sideName) {
        sideAlignersToCoverContext[sideName].startToothId = null;
        sideAlignersToCoverContext[sideName].endToothId = null;
        sideAlignersToCoverContext[sideName].lastToothId = null;
    });
    renderAlignersToCoverArch(arch);
}

function resetAlignersToCoverSideSelection(sideName) {
    var sideContext = sideAlignersToCoverContext[sideName];

    sideContext.startToothId = null;
    sideContext.endToothId = null;
    sideContext.lastToothId = null;
}

function clearAlignersToCoverSideVisualSelection(sideName) {
    var bounds = getAlignersToCoverSideBounds(sideName);
    var toothId;

    for (toothId = bounds.startToothId; toothId <= bounds.endToothId; toothId++) {
        $('.choose-tooth-aligners-to-cover[data-id="' + toothId + '"]')
            .removeClass('aligners-to-cover-start aligners-to-cover-end aligners-to-cover-selected');
        updateAlignersToCoverImageState(toothId, false);
    }
}

function renderAlignersToCoverArch(arch) {
    var archAnimationContext = sideAlignersToCoverContext[arch];
    var sideNames = getAlignersToCoverSideNamesByArch(arch);
    var containerSelector = getAlignersToCoverContainerSelector(arch);
    var summarySelector = getAlignersToCoverSummarySelector(arch);
    var selectedToothIds = [];
    var animatedToothIds = [];
    var lastToothLabels = [];
    var rangeSummaryParts = [];
    var summaryText;
    var shouldAnimate;
    var hasSelection = false;
    var normalizedStart;
    var normalizedEnd;
    var rangeLength;
    var sideContext;
    var sideToothIds;
    var sideAnimatedToothIds;
    var lastToothId;
    var sideLabel;
    var toothId;

    clearAlignersToCoverArchAnimation(arch);
    getNextAlignersToCoverAnimationRunId(arch);

    $(containerSelector).find('.choose-tooth-aligners-to-cover')
        .removeClass('aligners-to-cover-start aligners-to-cover-end aligners-to-cover-selected');
    resetAlignersToCoverArchImages(arch);

    $.each(sideNames, function(_, sideName) {
        sideContext = sideAlignersToCoverContext[sideName];

        if (sideContext.startToothId === null || sideContext.endToothId === null) {
            return;
        }

        hasSelection = true;
        normalizedStart = Math.min(sideContext.startToothId, sideContext.endToothId);
        normalizedEnd = Math.max(sideContext.startToothId, sideContext.endToothId);
        rangeLength = getAlignersToCoverRangeLength(normalizedStart, normalizedEnd);

        sideToothIds = getAlignersToCoverToothIdsFromRange(normalizedStart, normalizedEnd);
        sideAnimatedToothIds = getAlignersToCoverAnimationToothIdsForSide(sideName);

        selectedToothIds = selectedToothIds.concat(sideToothIds);
        animatedToothIds = animatedToothIds.concat(sideAnimatedToothIds);

        lastToothId = sideContext.lastToothId;
        if (lastToothId === null) {
            lastToothId = getAlignersToCoverLastToothIdFromRange(normalizedStart, normalizedEnd);
            sideContext.lastToothId = lastToothId;
        }

        sideLabel = sideName.toUpperCase();
        rangeSummaryParts.push(sideLabel + ': ' + getAlignersToCoverLabel(normalizedStart) + ' to ' + getAlignersToCoverLabel(normalizedEnd) + ' (' + rangeLength + ' teeth)');
        lastToothLabels.push(sideLabel + ' ' + getAlignersToCoverLabel(lastToothId));
    });

    if (!hasSelection) {
        $(summarySelector).text('Select the last ' + arch + ' tooth to cover with aligners.');
        syncAlignersToCoverStateInputs();
        return;
    }

    for (toothId = 0; toothId < selectedToothIds.length; toothId++) {
        $('.choose-tooth-aligners-to-cover[data-id="' + selectedToothIds[toothId] + '"]').addClass('aligners-to-cover-selected');
    }

    shouldAnimate = !archAnimationContext.suppressNextAnimation;
    archAnimationContext.suppressNextAnimation = false;

    if (shouldAnimate) {
        animateAlignersToCoverRange(arch, animatedToothIds);
    } else {
        for (toothId = 0; toothId < selectedToothIds.length; toothId++) {
            updateAlignersToCoverImageState(selectedToothIds[toothId], true);
        }
    }

    $.each(sideNames, function(_, sideName) {
        var sideLastToothId = sideAlignersToCoverContext[sideName].lastToothId;

        if (sideLastToothId !== null) {
            $('.choose-tooth-aligners-to-cover[data-id="' + sideLastToothId + '"]').addClass('aligners-to-cover-end');
        }
    });

    summaryText = arch.charAt(0).toUpperCase() + arch.slice(1) + ' range: ' + rangeSummaryParts.join(' | ') +
        '. Last tooth: ' + lastToothLabels.join(', ') + '. Click any tooth in this arch to update that side.';

    $(summarySelector).text(summaryText);
    syncAlignersToCoverStateInputs();
}

function setAlignersToCoverRangeFromTooth(toothId) {
    var sideName = getAlignersToCoverSide(toothId);
    var targetArch = getAlignersToCoverArchFromSide(sideName);
    var sideContext = sideAlignersToCoverContext[sideName];
    var anchoredRange = getAlignersToCoverAnchoredRangeFromLastTooth(toothId);

    clearAlignersToCoverSideVisualSelection(sideName);
    resetAlignersToCoverSideSelection(sideName);

    sideContext.startToothId = anchoredRange.startToothId;
    sideContext.endToothId = anchoredRange.endToothId;
    sideContext.lastToothId = toothId;
    renderAlignersToCoverArch(targetArch);
}

function getAlignersToCoverStateNumbers(stateName) {
    var rawValue = $(getAlignersToCoverStateInputId(stateName)).val();
    var values = [];

    if (!rawValue) {
        return values;
    }

    try {
        values = JSON.parse(rawValue);
    } catch (error) {
        values = [];
    }

    if (!Array.isArray(values)) {
        return [];
    }

    return $.map(values, function(value) {
        var number = parseInt(value, 10);
        return isNaN(number) ? null : number;
    });
}

function getAlignersToCoverSelectedToothIds(stateName) {
    var sideName = stateName.replace('tla_', '');
    var toothIds = [];

    $.each(getAlignersToCoverStateNumbers(stateName), function(_, number) {
        var toothId = getAlignersToCoverToothIdFromState(stateName, number);

        if (toothId !== null && getAlignersToCoverSide(toothId) === sideName) {
            toothIds.push(toothId);
        }
    });

    toothIds.sort(function(a, b) {
        return a - b;
    });

    return toothIds;
}

function initializeAlignersToCoverSide(sideName) {
    var stateName = getAlignersToCoverStateNameFromSide(sideName);
    var selectedToothIds = getAlignersToCoverSelectedToothIds(stateName);
    var sideContext = sideAlignersToCoverContext[sideName];
    var normalizedStart;
    var normalizedEnd;

    if (!selectedToothIds.length) {
        sideContext.startToothId = null;
        sideContext.endToothId = null;
        sideContext.lastToothId = null;
        return;
    }

    normalizedStart = selectedToothIds[0];
    normalizedEnd = selectedToothIds[selectedToothIds.length - 1];

    sideContext.startToothId = normalizedStart;
    sideContext.endToothId = normalizedEnd;
    sideContext.lastToothId = getAlignersToCoverLastToothIdFromRange(normalizedStart, normalizedEnd);
}

$(function() {
    ensureAlignersToCoverUi();
    ensureAlignersToCoverStateInputs();

    $('.choose-tooth-aligners-to-cover').each(function() {
        getAlignersToCoverDefaultImageSrc($(this));
    });

    initializeAlignersToCoverSide('ur');
    initializeAlignersToCoverSide('ul');
    initializeAlignersToCoverSide('lr');
    initializeAlignersToCoverSide('ll');

    sideAlignersToCoverContext.upper.suppressNextAnimation = true;
    sideAlignersToCoverContext.lower.suppressNextAnimation = true;

    renderAlignersToCoverArch('upper');
    renderAlignersToCoverArch('lower');
});

$(document).on('click', '.choose-tooth-aligners-to-cover', function() {
    var toothId = parseInt($(this).attr('data-id'), 10);

    setAlignersToCoverRangeFromTooth(toothId);
});
