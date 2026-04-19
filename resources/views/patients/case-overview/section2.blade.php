@php


$allSelections2 = [
    arr($patient->unerupted_teeth),
    arr($patient->extracted_teeth),
    arr($patient->tooth_movement_restrictions),
    arr($patient->coil),
    arr($patient->pontic),
    arr($patient->bridge),
];

// Tooth mappings
$upperTeeth = [
    1=>'UR-8',2=>'UR-7',3=>'UR-6',4=>'UR-5',
    5=>'UR-4',6=>'UR-3',7=>'UR-2',8=>'UR-1',
    9=>'UL-1',10=>'UL-2',11=>'UL-3',12=>'UL-4',
    13=>'UL-5',14=>'UL-6',15=>'UL-7',16=>'UL-8',
];

$upperSize = [
    1=>'1.2vw',2=>'1.3vw',3=>'1.3vw',4=>'1.3vw',
    5=>'1.3vw',6=>'1.3vw',7=>'1.3vw',8=>'1.6vw',
    9=>'1.6vw',10=>'1.3vw',11=>'1.3vw',12=>'1.3vw',
    13=>'1.3vw',14=>'1.3vw',15=>'1.3vw',16=>'1.2vw',
];

$lowerTeeth = [
    17=>'LR-8',18=>'LR-7',19=>'LR-6',20=>'LR-5',
    21=>'LR-4',22=>'LR-3',23=>'LR-2',24=>'LR-1',
    25=>'LL-1',26=>'LL-2',27=>'LL-3',28=>'LL-4',
    29=>'LL-5',30=>'LL-6',31=>'LL-7',32=>'LL-8',
];

$lowerSize = [
    17=>'1.2vw',18=>'1.3vw',19=>'1.5vw',20=>'1.3vw',
    21=>'1.3vw',22=>'1.35vw',23=>'1.2vw',24=>'1.15vw',
    25=>'1.15vw',26=>'1.2vw',27=>'1.35vw',28=>'1.3vw',
    29=>'1.3vw',30=>'1.5vw',31=>'1.3vw',32=>'1.2vw',
];

@endphp
<div class="row">
    <div style="margin:auto;">
        {{-- UPPER ARC --}}


        {{-- UPPER ARC --}}
        <div style="display:flex; flex-direction:column; align-items:center; width:100%;">
            <div style="display:flex; flex-direction:row; justify-content:center; gap:5px; width:100%; margin-bottom: 8px;">
                @foreach($upperTeeth as $id => $tooth)
                    @php
                        $unerupted_teeth = in_array($id, arr($patient->unerupted_teeth));
                        $extracted_teeth = in_array($id, arr($patient->extracted_teeth));
                        $tooth_movement_restrictions = in_array($id, arr($patient->tooth_movement_restrictions));
                        $coil = in_array($id, arr($patient->coil));
                        $pontic = in_array($id, arr($patient->pontic));
                        $bridge = in_array($id, arr($patient->bridge));
                    @endphp
                    <div style="width:{{$upperSize[$id]}};  display:flex; flex-direction: column; align-items:center; justify-content:flex-end; gap:6px;">

                        @if($bridge)
                            <img src="{{ asset('public/assets/tooth/png/bridge.png') }}" style=" width: 20px;" alt="Power Ridge Outer">
                        @endif

                        @if($tooth_movement_restrictions)
                            <img src="{{ asset('public/assets/tooth/png/movement.png') }}" style=" height: 12px;" alt="Power Ridge Outer">
                        @endif

                        @if($extracted_teeth)
                            <img src="{{ asset('public/assets/tooth/png/extracted.png') }}" style="height: 12px;" alt="Button Outer">
                        @endif

                        @if($coil)
                            <img src="{{ asset('public/assets/tooth/png/coil.png') }}" style=" width: 20px;" alt="Power Arm Attachment Outer">
                        @endif


                    </div>
                @endforeach
            </div>
        </div>



        <div style="display:flex; flex-wrap:wrap; justify-content:center; gap:5px;">
            @foreach($upperTeeth as $id => $tooth)
                @php
                    $unerupted_teeth = in_array($id, arr($patient->unerupted_teeth));
                    $pontic = in_array($id, arr($patient->pontic));
                    $selected = isSelected($id, $allSelections2);
                    if ($unerupted_teeth && !$pontic) {
                        $img = null; // Do not show image
                    } elseif ($pontic) {
                        $img = "public/assets/tooth/coloured/$tooth.png";
                    } else {
                        $img = $selected
                            ? "public/assets/tooth/png/selected/$tooth.png"
                            : "public/assets/tooth/png/$tooth.png";
                    }
                @endphp

                @if($img)
                <img id="{{ $id }}"
                    class="choose-tooth"
                    src="{{ asset($img) }}"
                    style="width:{{$upperSize[$id]}}; height:{{$upperSize[$id]}}; margin:5px 0;">
                @endif
            @endforeach
        </div>

        {{-- DIVIDER --}}
        <div style="display:flex; align-items:center; margin:5px 0;">
            <strong>R</strong>
            <div style="flex:1; height:1px; background:#ccc; margin:0 10px;"></div>
            <strong>L</strong>
        </div>

        {{-- LOWER ARC --}}
        <div style="display:flex; flex-wrap:wrap; justify-content:center; gap:5px;">
            @foreach($lowerTeeth as $id => $tooth)
                @php
                    $pontic = in_array($id, arr($patient->pontic));
                    $selected = isSelected($id, $allSelections2);
                    if ($pontic) {
                        $img = "public/assets/tooth/coloured/$tooth.png";
                    } else {
                        $img = $selected
                            ? "public/assets/tooth/png/selected/$tooth.png"
                            : "public/assets/tooth/png/$tooth.png";
                    }
                @endphp

                <img id="{{ $id }}"
                    class="choose-tooth"
                    src="{{ asset($img) }}"
                    style="width:{{$lowerSize[$id]}}; height:{{$lowerSize[$id]}}; margin:5px 0;">
            @endforeach
        </div>

        <div style="display:flex; flex-direction:row; justify-content:center; gap:5px; width:100%;margin-top: 4px;">
            @foreach($lowerTeeth as $id => $tooth)
                @php
                     $unerupted_teeth = in_array($id, arr($patient->unerupted_teeth));
                    $extracted_teeth = in_array($id, arr($patient->extracted_teeth));
                    $tooth_movement_restrictions = in_array($id, arr($patient->tooth_movement_restrictions));
                    $coil = in_array($id, arr($patient->coil));
                    $pontic = in_array($id, arr($patient->pontic));
                    $bridge = in_array($id, arr($patient->bridge));
                @endphp
                {{-- <div style="width:{{$lowerSize[$id]}}; height:18px; display:flex; align-items:center; justify-content:center;"> --}}
                <div style="width:{{$lowerSize[$id]}};  display:flex; flex-direction: column; align-items:center; justify-content:flex-start; gap:6px;">
                    @if($coil)
                        <img src="{{ asset('public/assets/tooth/png/coil.png') }}" style=" width: 20px;" alt="Power Arm Attachment Outer">
                    @endif

                    @if($extracted_teeth)
                        <img src="{{ asset('public/assets/tooth/png/extracted.png') }}" style="height: 12px;" alt="Button Outer">
                    @endif

                    @if($tooth_movement_restrictions)
                        <img src="{{ asset('public/assets/tooth/png/movement.png') }}" style=" height: 12px;" alt="Power Ridge Outer">
                    @endif

                    @if($bridge)
                        <img src="{{ asset('public/assets/tooth/png/bridge.png') }}" style=" width: 20px;" alt="Power Ridge Outer">
                    @endif

                </div>
            @endforeach
        </div>
    </div>

</div>
<br>
{{--
<div class="row">
    <div class="teeth-layout-wrapper" style="max-width: 1200px; margin: 0 auto;">
        <div class="media img-responsive input-group" style="display:flex; flex-wrap: wrap; justify-content:center; gap:5px;" id="classIIUpperArcNew">

            <div class="tooth-wrapper" style="position: relative; display: inline-block;">
                <img id="1" class="choose-tooth" src="{{ asset('public/assets/tooth/png/UR-8.png') }}" style="vertical-align: baseline;width: 1.2vw; height: 1.2vw; margin-top: 5px; margin-bottom: 3px;">
            </div>

            <img id="2" class="choose-tooth" src="{{ asset('public/assets/tooth/png/UR-7.png') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px; margin-bottom: 3px;">
            <img id="3" class="choose-tooth" src="{{ asset('public/assets/tooth/png/UR-6.png') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px; margin-bottom: 3px;">
            <img id="4" class="choose-tooth" src="{{ asset('public/assets/tooth/png/UR-5.png') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px; margin-bottom: 3px;">
            <img id="5" class="choose-tooth" src="{{ asset('public/assets/tooth/png/UR-4.png') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px; margin-bottom: 3px;">
            <img id="6" class="choose-tooth" src="{{ asset('public/assets/tooth/png/UR-3.png') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px; margin-bottom: 3px;">
            <img id="7" class="choose-tooth" src="{{ asset('public/assets/tooth/png/UR-2.png') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px; margin-bottom: 3px;">
            <img id="8" class="choose-tooth" src="{{ asset('public/assets/tooth/png/UR-1.png') }}" style="vertical-align: baseline;width: 1.6vw; height: 1.6vw; margin-top: 5px; margin-bottom: 3px;">
            <img id="9" class="choose-tooth" src="{{ asset('public/assets/tooth/png/UL-1.png') }}" style="vertical-align: baseline;width: 1.6vw; height: 1.6vw; margin-top: 5px; margin-bottom: 3px;">
            <img id="10" class="choose-tooth" src="{{ asset('public/assets/tooth/png/UL-2.png') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px; margin-bottom: 3px;">
            <img id="11" class="choose-tooth" src="{{ asset('public/assets/tooth/png/UL-3.png') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px; margin-bottom: 3px;">
            <img id="12" class="choose-tooth" src="{{ asset('public/assets/tooth/png/UR-4.png') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px; margin-bottom: 3px;">
            <img id="13" class="choose-tooth" src="{{ asset('public/assets/tooth/png/UR-5.png') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px; margin-bottom: 3px;">
            <img id="14" class="choose-tooth" src="{{ asset('public/assets/tooth/png/UR-6.png') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px; margin-bottom: 3px;">
            <img id="15" class="choose-tooth" src="{{ asset('public/assets/tooth/png/UR-7.png') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px; margin-bottom: 3px;">
            <img id="16" class="choose-tooth" src="{{ asset('public/assets/tooth/png/UR-8.png') }}" style="vertical-align: baseline;width: 1.2vw; height: 1.2vw; margin-top: 5px; margin-bottom: 3px;">
        </div>
        <div class="teeth-divider" style="display:flex; align-items:center; justify-content:center; gap:1rem;">
            <span style="font-weight:bold;">R</span>
            <span style="flex:1; height:1px; background: rgba(177, 175, 175, 0.70);"></span>
            <span style="font-weight:bold;">L</span>
        </div>
        <div class="media img-responsive input-group" style="display:flex; flex-wrap: wrap; justify-content:center; gap:5px; position:relative; padding:0.5rem 0 25px;" id="classIILowerArc">
            <img id="17" class="choose-tooth"  src="{{  asset('public/assets/tooth/png/LR-8.png') }}" style="vertical-align: baseline;width: 1.2vw; height: 1.2vw; margin-top: 5px;">
            <img id="18" class="choose-tooth"  src="{{  asset('public/assets/tooth/png/LR-7.png') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px;">
            <img id="19" class="choose-tooth"  src="{{  asset('public/assets/tooth/png/LR-6.png') }}" style="vertical-align: baseline;width: 1.5vw; height: 1.5vw; margin-top: 5px;">
            <img id="20" class="choose-tooth"  src="{{  asset('public/assets/tooth/png/LR-5.png') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px;">
            <img id="21" class="choose-tooth"  src="{{  asset('public/assets/tooth/png/LR-4.png') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px;">
            <img id="22" class="choose-tooth"  src="{{  asset('public/assets/tooth/png/LR-3.png') }}" style="vertical-align: baseline;width: 1.35vw; height: 1.35vw; margin-top: 5px;">
            <img id="23" class="choose-tooth"  src="{{  asset('public/assets/tooth/png/LR-2.png') }}" style="vertical-align: baseline;width: 1.2vw; height: 1.2vw; margin-top: 5px;">
            <img id="24" class="choose-tooth"  src="{{  asset('public/assets/tooth/png/LR-1.png') }}" style="vertical-align: baseline;width: 1.15vw; height: 1.15vw; margin-top: 5px;">
            <img id="25" class="choose-tooth"  src="{{  asset('public/assets/tooth/png/LL-1.png') }}" style="vertical-align: baseline;width: 1.15vw; height: 1.15vw; margin-top: 5px;">
            <img id="26" class="choose-tooth"  src="{{  asset('public/assets/tooth/png/LL-2.png') }}" style="vertical-align: baseline;width: 1.2vw; height: 1.2vw; margin-top: 5px;">
            <img id="27" class="choose-tooth"  src="{{  asset('public/assets/tooth/png/LL-3.png') }}" style="vertical-align: baseline;width: 1.35vw; height: 1.35vw; margin-top: 5px;">
            <img id="28" class="choose-tooth"  src="{{  asset('public/assets/tooth/png/LL-4.png') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px;">
            <img id="29" class="choose-tooth"  src="{{  asset('public/assets/tooth/png/LL-5.png') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px;">
            <img id="30" class="choose-tooth"  src="{{  asset('public/assets/tooth/png/LL-6.png') }}" style="vertical-align: baseline;width: 1.5vw; height: 1.5vw; margin-top: 5px;">
            <img id="31" class="choose-tooth"  src="{{  asset('public/assets/tooth/png/LL-7.png') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px;">
            <img id="32" class="choose-tooth"  src="{{  asset('public/assets/tooth/png/LL-8.png') }}" style="vertical-align: baseline;width: 1.2vw; height: 1.2vw; margin-top: 5px;">
        </div>
    </div>
</div> --}}

