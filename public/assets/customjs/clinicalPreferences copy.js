var isDirty = false;
var selectedButtonToothNumbers = [];
var selectedDistalHooksToothNumbers = [];
var selectedMesialHooksToothNumbers = [];

var viewClassIIButton =[];
var viewClassIIHook =[];
var viewClassIIIButton =[];
var viewClassIIIHook =[];
var selectedClassIIDistalHookToothNumbers =[];
var selectedClassIIMesialHookToothNumbers =[];
var selectedClassIIBtnToothNumbers =[];
var selectedClassIIIntegratedHooksNumbers =[];
var selectedClassIIIDistalHookToothNumbers =[];
var selectedClassIIIMesialHookToothNumbers =[];
var selectedClassIIIBtnToothNumbers =[];
var selectedClassIIIIntegratedHooksNumbers =[];
var viewSelectedClassIIIntegratedHooksNumbers =[];
var viewSelectedClassIIIIntegratedHooksNumbers =[];
var viewSelectedClassIIHookToothNumbers = [];
var viewSelectedClassIIIHookToothNumbers = [];
var commentsCharLimit=1500;
let ensureLeaveTargetLink = '';

function placeCutout(toothNumber, classSelected){
    var arc = toothNumber < 17 ? "classIIUpperArc" : "classIILowerArc";
    var cutoutTypeSelected = $("input[name='classIICutOut']:checked"). val();

    if(cutoutTypeSelected == "classIIBtn"){
        toothSelectButton(toothNumber,arc,classSelected);
    }

    if(cutoutTypeSelected == "classIIHook" && arc == "classIIUpperArc"){
        toothSelectHook(toothNumber,arc,classSelected,"classIIDistalHook");
    }

    if(cutoutTypeSelected == "classIIHook" && arc == "classIILowerArc"){
        toothSelectHook(toothNumber,arc,classSelected,"classIIMesialHook");
    }

    if (cutoutTypeSelected == 'classIIIntegratedHooks'){
        toothSelectIntegratedHook(toothNumber,arc,classSelected);
    }
}

function toothSelectButton(toothNumber,arc,classSelected){

    var symbolValue = "B"+classSelected;
    var btnSymbol = $("#"+symbolValue + toothNumber + "");
    if (btnSymbol.length) {
        btnSymbol.remove();
        applyVerticalCutoutLayout(toothNumber, arc, classSelected);
        if(classSelected == "classII"){
            selectedClassIIBtnToothNumbers = $.grep(selectedClassIIBtnToothNumbers, function(value) {
                return value != toothNumber;
            });

            viewClassIIButton = $.grep(viewClassIIButton, function(value) {
                return value != getToothNotation(toothNumber, 'Universal')
            });

            $("#viewClassIIButton").html(viewClassIIButton.join(", "));
        }
        else if(classSelected == "classIII"){

            selectedClassIIIBtnToothNumbers = $.grep(selectedClassIIIBtnToothNumbers, function(value) {
                return value != toothNumber;
            });

            viewClassIIIButton = $.grep(viewClassIIIButton, function(value) {
                return value != getToothNotation(toothNumber, doctorTNS)
            });

            $("#viewClassIIIButton").html(viewClassIIIButton.join(", "));
        }
    } else {
        if(arc== "classIIUpperArc" || arc == "classIILowerArc"){
            selectedClassIIBtnToothNumbers.push(toothNumber);
            viewClassIIButton.push(getToothNotation(toothNumber, 'Universal'));
            $("#viewClassIIButton").html(viewClassIIButton.join(", "));
        }
        placeButtonSymbol (toothNumber,arc,symbolValue,classSelected);
    }

    $("#selectedClassIIButtonToothNumbers").val(selectedClassIIBtnToothNumbers);
    $("#selectedClassIIIButtonToothNumbers").val(selectedClassIIIBtnToothNumbers);
}

function toothSelectHook(toothNumber,arc,classSelected,hookType) {

	 var doctorTNS = 'Universal';

	 var symbolValue = null;
	 if(hookType == 'classIIDistalHook' || hookType == 'classIIIDistalHook'){
			symbolValue = "HD"+classSelected;
	 }else if(hookType == 'classIIMesialHook' || hookType == 'classIIIMesialHook'){
			symbolValue = "HM"+classSelected;
	 }

	 var btnSymbol = $("#"+symbolValue + toothNumber + "");

		//check if tooth is already selected then remove selection and remove symbol.
		if (btnSymbol.length) {
			btnSymbol.remove();
			applyVerticalCutoutLayout(toothNumber, arc, classSelected);

			if(classSelected == "classII"){
				if(hookType == 'classIIDistalHook'){
					selectedClassIIDistalHookToothNumbers.push(toothNumber);

					selectedClassIIDistalHookToothNumbers = $.grep(selectedClassIIDistalHookToothNumbers, function(value) {
				        return value != toothNumber;
					});

					viewClassIIHook = $.grep(viewClassIIHook, function(value) {
					  return value != getToothNotation(toothNumber, doctorTNS)});
					$("#viewClassIIHook").html(viewClassIIHook.join(", "));
				}
				else if(hookType == 'classIIMesialHook'){
					selectedClassIIMesialHookToothNumbers.push(toothNumber);

					selectedClassIIMesialHookToothNumbers = $.grep(selectedClassIIMesialHookToothNumbers, function(value) {
				        return value != toothNumber;
					});

					viewClassIIHook = $.grep(viewClassIIHook, function(value) {
					  return value != getToothNotation(toothNumber, doctorTNS)});
					$("#viewClassIIHook").html(viewClassIIHook.join(", "));
				}
			}
			else if(classSelected == "classIII"){
				if(hookType == 'classIIIDistalHook'){
					selectedClassIIIDistalHookToothNumbers.push(toothNumber);

					selectedClassIIIDistalHookToothNumbers = $.grep(selectedClassIIIDistalHookToothNumbers, function(value) {
				        return value != toothNumber;
					});

					viewClassIIIHook = $.grep(viewClassIIIHook, function(value) {
					  return value != getToothNotation(toothNumber, doctorTNS)});
					$("#viewClassIIIHook").html(viewClassIIIHook.join(", "));
				}
				else if(hookType == 'classIIIMesialHook'){
					selectedClassIIIMesialHookToothNumbers.push(toothNumber);

					selectedClassIIIMesialHookToothNumbers = $.grep(selectedClassIIIMesialHookToothNumbers, function(value) {
				        return value != toothNumber;
					});

					viewClassIIIHook = $.grep(viewClassIIIHook, function(value) {
					  return value != getToothNotation(toothNumber, doctorTNS)});
					$("#viewClassIIIHook").html(viewClassIIIHook.join(", "));
				}
			}

		} else  {	//else select tooth and place symbol

			if(classSelected == "classII"){
				if(hookType == 'classIIDistalHook'){
					symbolValue = "HD"+classSelected;
					selectedClassIIDistalHookToothNumbers.push(toothNumber);
					viewClassIIHook.push(getToothNotation(toothNumber, doctorTNS));
				}
				else if(hookType == 'classIIMesialHook'){
					symbolValue = "HM"+classSelected;
					selectedClassIIMesialHookToothNumbers.push(toothNumber);
					viewClassIIHook.push(getToothNotation(toothNumber, doctorTNS));
				}
				$("#viewClassIIHook").html(viewClassIIHook.join(", "));
			}
			else if(classSelected == "classIII"){
				if(hookType == 'classIIIDistalHook'){
					symbolValue = "HD"+classSelected;
					selectedClassIIIDistalHookToothNumbers.push(toothNumber);
				   	viewClassIIIHook.push(getToothNotation(toothNumber, doctorTNS));
				    $("#viewClassIIIHook").html(viewClassIIIHook.join(", "));
				}
				else if(hookType == 'classIIIMesialHook'){
					symbolValue = "HM"+classSelected;
					selectedClassIIIMesialHookToothNumbers.push(toothNumber);
				   	viewClassIIIHook.push(getToothNotation(toothNumber, doctorTNS));
				    $("#viewClassIIIHook").html(viewClassIIIHook.join(", "));
				}
			}

		    placeHookSymbol (toothNumber,arc,symbolValue,classSelected);

	 }
		$("#selectedClassIIDistalHookToothNumbers").val(selectedClassIIDistalHookToothNumbers);
		$("#selectedClassIIIDistalHookToothNumbers").val(selectedClassIIIDistalHookToothNumbers);
		$("#selectedClassIIMesialHookToothNumbers").val(selectedClassIIMesialHookToothNumbers);
		$("#selectedClassIIIMesialHookToothNumbers").val(selectedClassIIIMesialHookToothNumbers);
}

function toothSelectIntegratedHook(toothNumber,arc,classSelected) {

	var doctorTNS = 'Universal';
	var symbolValue = "IH"+classSelected;
	var integratedHookSymbol = $("#"+symbolValue + toothNumber + "");

	//check if tooth is already selected then remove selection and remove symbol.
	if (integratedHookSymbol.length) {
		integratedHookSymbol.remove();
		applyVerticalCutoutLayout(toothNumber, arc, classSelected);

		if(classSelected == "classII"){

			selectedClassIIIntegratedHooksNumbers = $.grep(selectedClassIIIntegratedHooksNumbers, function(value) {
				return value != toothNumber;
			});

			viewSelectedClassIIIntegratedHooksNumbers = $.grep(
				viewSelectedClassIIIntegratedHooksNumbers,
				function(value) {
					return value != getToothNotation(toothNumber, doctorTNS)
				}
			);

			$("#viewClassIIIntegratedHooks").html(viewSelectedClassIIIntegratedHooksNumbers.join(", "));
		}


		if(classSelected == "classIII"){

			selectedClassIIIIntegratedHooksNumbers = $.grep(selectedClassIIIIntegratedHooksNumbers, function(value) {
				return value != toothNumber;
			});

			viewSelectedClassIIIIntegratedHooksNumbers = $.grep(
				viewSelectedClassIIIIntegratedHooksNumbers,
				function(value) {
					return value != getToothNotation(toothNumber, doctorTNS)
				}
			);

			$("#viewClassIIIIntegratedHooks").html(viewSelectedClassIIIIntegratedHooksNumbers.join(", "));
		}

	} else  {	//else select tooth and place symbol

		if(arc== "classIIUpperArc" || arc == "classIILowerArc"){
			selectedClassIIIntegratedHooksNumbers.push(toothNumber);
			viewSelectedClassIIIntegratedHooksNumbers.push(getToothNotation(toothNumber, doctorTNS));
			$("#viewClassIIIntegratedHooks").html(viewSelectedClassIIIntegratedHooksNumbers.join(", "));
		}
		else if(arc== "classIIIUpperArc" || arc == "classIIILowerArc"){
			selectedClassIIIIntegratedHooksNumbers.push(toothNumber);
			viewSelectedClassIIIIntegratedHooksNumbers.push(getToothNotation(toothNumber, doctorTNS));
			$("#viewClassIIIIntegratedHooks").html(viewSelectedClassIIIIntegratedHooksNumbers.join(", "));
		}
		placeIntegratedHookSymbol(toothNumber,arc,symbolValue,classSelected);

	}
	$("#selectedClassIIIntegratedHooksToothNumbers").val(selectedClassIIIntegratedHooksNumbers);
	$("#selectedClassIIIIntegratedHooksToothNumbers").val(selectedClassIIIIntegratedHooksNumbers);

}

function getToothNotation(toothNumber,doctorTNS){
	if(doctorTNS == 'Universal'){
		return toothNumber;
    }
	else return null;
}

/**
 * Places button, hook, and integrated overlays on the same vertical line (shared horizontal center).
 * One icon: centered on the tooth; two or three: stacked vertically with even spacing.
 */
function applyVerticalCutoutLayout(teeth, upperLowerSection, classSelected) {
	var selectedTeeth = $("#" + teeth + "");
	if (!selectedTeeth.length) {
		return;
	}
	var left = selectedTeeth.position().left;
	var image = document.getElementById(teeth);
	if (!image) {
		return;
	}
	var width = image.clientWidth;
	var suffix = classSelected + teeth;
	var b = $("#B" + suffix);
	var hd = $("#HD" + suffix);
	var hm = $("#HM" + suffix);
	var ih = $("#IH" + suffix);

	var stack = [];
	if (b.length) {
		stack.push({ el: b, integrated: false });
	}
	if (hd.length) {
		stack.push({ el: hd, integrated: false });
	}
	if (hm.length) {
		stack.push({ el: hm, integrated: false });
	}
	if (ih.length) {
		stack.push({ el: ih, integrated: true });
	}

	var n = stack.length;
	if (!n) {
		return;
	}

	var baseTop = (upperLowerSection == "classIILowerArc" || upperLowerSection == "classIIILowerArc") ? 11.25 : 22.5;
	var gap = 9;
	var offsets;
	if (n === 1) {
		offsets = [0];
	} else if (n === 2) {
		offsets = [-gap, gap];
	} else {
		offsets = [-gap, 0, gap];
	}

	for (var i = 0; i < n; i++) {
		var item = stack[i];
		var def = item.integrated ? 7 : 2.5;
		var mw = item.integrated ? "18px" : "14px";
		item.el.css("position", "absolute");
		item.el.css("top", baseTop + offsets[i]);
		item.el.css("left", left + (width * 0.5) - def);
		item.el.css("z-index", 100 + i);
		item.el.css("max-width", mw);
	}
}

function placeHookSymbol(teeth, upperLowerSection,symbolId,selectedClass) {
	createButtonHookImage( symbolId + teeth,teeth,upperLowerSection,"Hook.png",selectedClass);
	applyVerticalCutoutLayout(teeth, upperLowerSection, selectedClass);
}

function placeButtonSymbol(teeth, upperLowerSection,symbolId,selectedClass) {
	createButtonHookImage( symbolId + teeth,teeth,upperLowerSection,"Button.png",selectedClass);
	applyVerticalCutoutLayout(teeth, upperLowerSection, selectedClass);
}


function createButtonHookImage(id,teeth,upperLowerSection, imageurl,selectedClass){
	var teethSection = document.getElementById(upperLowerSection);
	var x = document.createElement("IMG");
	x.setAttribute("id", id);
	x.setAttribute("class", id.substring(0, 2)+teeth);
	x.setAttribute("src", baseUrl  + "/public/assets/tooth/"+imageurl);
	x.setAttribute("onClick", "placeCutout('" + teeth + "','"+selectedClass+"')");
	teethSection.appendChild(x);
}

function placeIntegratedHookSymbol(teeth, upperLowerSection,symbolId,selectedClass) {
	createButtonHookImage( symbolId + teeth,teeth,upperLowerSection,"IntegratedHook.svg",selectedClass);
	if (typeof setIntegratedHookOrientation === "function") {
		setIntegratedHookOrientation(symbolId + teeth, teeth, upperLowerSection, selectedClass);
	}
	applyVerticalCutoutLayout(teeth, upperLowerSection, selectedClass);
}


