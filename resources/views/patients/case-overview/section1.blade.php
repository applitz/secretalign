@php

$allSelections = [
    arr($patient->button_outer),
    arr($patient->button_inner),
    arr($patient->ihook_outer),
    arr($patient->ihook_inner),
    arr($patient->precision_cut_outer),
    arr($patient->precision_cut_inner),
    arr($patient->power_arm_attachment_outer),
    arr($patient->power_arm_attachment_inner),
    arr($patient->power_ridge_outer),
    arr($patient->power_ridge_inner),
    arr($patient->bite_turbos),
    arr($patient->bite_ramp),
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
    17=>'1.2vw',18=>'1.4vw',19=>'1.5vw',20=>'1.4vw',
    21=>'1.4vw',22=>'1.35vw',23=>'1.2vw',24=>'1.15vw',
    25=>'1.15vw',26=>'1.2vw',27=>'1.35vw',28=>'1.4vw',
    29=>'1.4vw',30=>'1.5vw',31=>'1.4vw',32=>'1.2vw',
];

@endphp
<div class="row">
    <div style="margin:auto;">
        {{-- UPPER ARC --}}
        <div style="display:flex; flex-direction:column; align-items:center; width:100%;">

            <div style="display:flex; flex-direction:row; justify-content:center; gap:5px; width:100%; margin-bottom: 8px;">
                @foreach($upperTeeth as $id => $tooth)
                    @php
                        $buttonOuter = in_array($id, arr($patient->button_outer));
                        $ihookOuter = in_array($id, arr($patient->ihook_outer));
                        $precision_cut_outer = in_array($id, arr($patient->precision_cut_outer));
                        $bite_turbos = in_array($id, arr($patient->bite_turbos));
                        $bite_ramp = in_array($id, arr($patient->bite_ramp));
                        $power_arm_attachment_outer = in_array($id, arr($patient->power_arm_attachment_outer));
                        $power_ridge_outer = in_array($id, arr($patient->power_ridge_outer));
                    @endphp
                    <div style="width:{{$upperSize[$id]}};  display:flex; flex-direction: column; align-items:center; justify-content:flex-end; gap:6px;">
                        @if($buttonOuter)
                            <img src="{{ asset('public/assets/tooth/png/buttons.png') }}" style="width: 16px; height: 16px;" alt="Button Outer">
                        @endif

                        @if($ihookOuter)
                            @if($id >=1 && $id <= 8)
                                <img src="{{ asset('public/assets/tooth/png/I-hook-UR.png') }}" style="width: 16px; height: 16px;" alt="I-Hook Outer">
                            @else
                                <img src="{{ asset('public/assets/tooth/png/I-hook-UL.png') }}" style="width: 16px; height: 16px;" alt="I-Hook Outer">
                            @endif
                        @endif
                        @if($precision_cut_outer)
                            @if($id >=1 && $id <= 8)
                                <img src="{{ asset('public/assets/tooth/png/precisioncut-UR.png') }}" style="width: 16px; height: 16px;" alt="precisioncut Outer">
                            @else
                                <img src="{{ asset('public/assets/tooth/png/precisioncut-UL.png') }}" style="width: 16px; height: 16px;" alt="precisioncut Outer">
                            @endif
                        @endif

                        @if($power_arm_attachment_outer)
                            <img src="{{ asset('public/assets/tooth/png/Power-Arm-Attachment.png') }}" style="width: 12px; height: 20px;" alt="Power Arm Attachment Outer">
                        @endif

                        @if($power_ridge_outer)
                            <img src="{{ asset('public/assets/tooth/png/Power-Ridge.png') }}" style="width: 16px; height: 10px;" alt="Power Ridge Outer">
                        @endif
                    </div>
                @endforeach
            </div>

            <div style="display:flex; flex-direction:row; justify-content:center; gap:5px; width:100%; margin-bottom: 4px;">
                @foreach($upperTeeth as $id => $tooth)
                    @php
                        $selected = isSelected($id, $allSelections);
                        $img = $selected
                            ? "public/assets/tooth/png/selected/$tooth.png"
                            : "public/assets/tooth/png/$tooth.png";
                    @endphp
                    <div style="width:{{$upperSize[$id]}}; height:{{$upperSize[$id]}}; display:flex; align-items:center; justify-content:center; position:relative;">
                        <img id="{{ $id }}"
                            class="choose-tooth"
                            src="{{ asset($img) }}"
                            style="width:100%; height:100%; display:block;">
                        @php
                            $biteRampUpperIds = [6,7,8,9,10,11];
                            $biteTurbosUpperIds = [1,2,3,4,5,12,13,14,15,16];
                            $bite_ramp = in_array($id, arr($patient->bite_ramp));
                            $bite_turbos = in_array($id, arr($patient->bite_turbos));
                        @endphp
                        @if($bite_ramp && in_array($id, $biteRampUpperIds))
                            <img src="{{ asset('public/assets/tooth/png/Bite-Ramp.png') }}" style="width: 14px; height: 14px; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); object-fit: contain; pointer-events: none;" alt="Bite Ramp Upper">
                        @endif
                        @if($bite_turbos && in_array($id, $biteTurbosUpperIds))
                            <img src="{{ asset('public/assets/tooth/png/Bite-Turbos.png') }}" style="width: 14px; height: 14px; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); object-fit: contain; pointer-events: none;" alt="Bite Turbos Upper">
                        @endif
                    </div>
                @endforeach
            </div>

            <div style="display:flex; flex-direction:row; justify-content:center; gap:5px; width:100%; margin-bottom: 4px;">
                @foreach($upperTeeth as $id => $tooth)
                    @php
                        $buttonInner = in_array($id, arr($patient->button_inner));
                        $ihookInner = in_array($id, arr($patient->ihook_inner));
                        $precisionCutInner = in_array($id, arr($patient->precision_cut_inner));
                        $power_ridge_inner = in_array($id, arr($patient->power_ridge_inner));
                        $power_arm_attachment_inner = in_array($id, arr($patient->power_arm_attachment_inner));
                    @endphp

                    <div style="width:{{$upperSize[$id]}};  display:flex; flex-direction: column; align-items:center; justify-content:flex-start; gap:6px;">

                        @if($power_ridge_inner)
                            <img src="{{ asset('public/assets/tooth/png/Power-Ridge.png') }}" style="width: 16px; height: 10px;" alt="Power Arm Attachment Outer">
                        @endif



                        @if($power_arm_attachment_inner)
                            <img src="{{ asset('public/assets/tooth/png/Power-Arm-Attachment-lower.png') }}" style="width: 12px; height: 20px;" alt="Power Arm Attachment Inner">
                        @endif


                        @if($buttonInner)
                            <img src="{{ asset('public/assets/tooth/png/buttons.png') }}" style="width: 16px; height: 16px;" alt="Button Inner">
                        @endif


                        @if($ihookInner)
                            @if($id >=1 && $id <= 8)
                                <img src="{{ asset('public/assets/tooth/png/I-hook-LR.png') }}" style="width: 16px; height: 16px;" alt="I-Hook Outer">
                            @else
                                <img src="{{ asset('public/assets/tooth/png/I-hook-LL.png') }}" style="width: 16px; height: 16px;" alt="I-Hook Outer">
                            @endif
                        @endif

                        @if($precisionCutInner)
                            @if($id >=1 && $id <= 8)
                                <img src="{{ asset('public/assets/tooth/png/precisioncut-LR.png') }}" style="width: 16px; height: 16px;" alt="precisioncut Inner">
                            @else
                                <img src="{{ asset('public/assets/tooth/png/precisioncut-LL.png') }}" style="width: 16px; height: 16px;" alt="precisioncut Inner">
                            @endif
                        @endif
                    </div>
                @endforeach
            </div>
        </div>


        {{-- DIVIDER --}}
        <div style="display:flex; align-items:center; ">
            <strong>R</strong>
            <div style="flex:1; height:1px; background:#ccc; margin:0 10px;"></div>
            <strong>L</strong>
        </div>

        {{-- LOWER ARC --}}
        <div style="display:flex; flex-direction:column; align-items:center; width:100%;">
            <div style="display:flex; flex-direction:row; justify-content:center; gap:5px; width:100%;margin-top: 4px;">
                @foreach($lowerTeeth as $id => $tooth)
                    @php
                        $buttonOuter = in_array($id, arr($patient->button_outer));
                        $ihookOuter = in_array($id, arr($patient->ihook_outer));
                        $precision_cut_outer = in_array($id, arr($patient->precision_cut_outer));
                        $power_ridge_outer = in_array($id, arr($patient->power_ridge_outer));
                        $power_arm_attachment_outer = in_array($id, arr($patient->power_arm_attachment_outer));
                    @endphp
                    <div style="width:{{$lowerSize[$id]}};  display:flex; flex-direction: column; align-items:center; justify-content:flex-end; gap:6px;">
                        @if($buttonOuter)
                            <img src="{{ asset('public/assets/tooth/png/buttons.png') }}" style="width: 16px; height: 16px;" alt="Button Outer">
                        @endif

                        @if($ihookOuter)
                            @if($id >=17 && $id <= 24)
                                <img src="{{ asset('public/assets/tooth/png/I-hook-UR.png') }}" style="width: 16px; height: 16px;" alt="I-Hook Outer">
                            @else
                                <img src="{{ asset('public/assets/tooth/png/I-hook-UL.png') }}" style="width: 16px; height: 16px;" alt="I-Hook Outer">
                            @endif
                        @endif

                        @if($precision_cut_outer)
                            @if($id >=16 && $id <= 24)
                                <img src="{{ asset('public/assets/tooth/png/precisioncut-UR.png') }}" style="width: 16px; height: 16px;" alt="precisioncut Inner">
                            @else
                                <img src="{{ asset('public/assets/tooth/png/precisioncut-UL.png') }}" style="width: 16px; height: 16px;" alt="precisioncut Inner">
                            @endif
                        @endif

                        @if($power_arm_attachment_outer)
                            <img src="{{ asset('public/assets/tooth/png/Power-Arm-Attachment.png') }}" style="width: 12px; height: 20px;" alt="Power Arm Attachment Outer">
                        @endif

                        @if($power_ridge_outer)
                            <img src="{{ asset('public/assets/tooth/png/Power-Ridge.png') }}" style="width: 16px; height: 10px;" alt="Power Ridge Outer">
                        @endif

                    </div>
                @endforeach
            </div>
            <div style="display:flex; flex-direction:row; justify-content:center; gap:5px; width:100%;margin-top: 8px;">
                @foreach($lowerTeeth as $id => $tooth)
                    @php
                        $selected = isSelected($id, $allSelections);
                        $img = $selected
                            ? "public/assets/tooth/png/selected/$tooth.png"
                            : "public/assets/tooth/png/$tooth.png";
                    @endphp
                    <div style="width:{{$lowerSize[$id]}}; height:{{$lowerSize[$id]}}; display:flex; align-items:center; justify-content:center; position:relative;">
                        <img id="{{ $id }}"
                            class="choose-tooth"
                            src="{{ asset($img) }}"
                            style="width:100%; height:100%; display:block;">
                        @php
                            $biteRampLowerIds = [22,23,24,25,26,27];
                            $biteTurbosLowerIds = [17,18,19,20,21,28,29,30,31,32];
                            $bite_ramp = in_array($id, arr($patient->bite_ramp));
                            $bite_turbos = in_array($id, arr($patient->bite_turbos));
                        @endphp
                        @if($bite_ramp && in_array($id, $biteRampLowerIds))
                            <img src="{{ asset('public/assets/tooth/png/Bite-Ramp-lower.png') }}" style="width: 14px; height: 14px; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); object-fit: contain; pointer-events: none;" alt="Bite Ramp Lower">
                        @endif
                        @if($bite_turbos && in_array($id, $biteTurbosLowerIds))
                            <img src="{{ asset('public/assets/tooth/png/Bite-Turbos.png') }}" style="width: 14px; height: 14px; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); object-fit: contain; pointer-events: none;" alt="Bite Turbos Lower">
                        @endif
                    </div>
                @endforeach
            </div>
            <div style="display:flex; flex-direction:row; justify-content:center; gap:5px; width:100%;margin-top: 4px;">
                @foreach($lowerTeeth as $id => $tooth)
                    @php
                        $buttonInner = in_array($id, arr($patient->button_inner));
                        $ihookInner = in_array($id, arr($patient->ihook_inner));
                        $precisionCutInner = in_array($id, arr($patient->precision_cut_inner));
                        $power_ridge_inner = in_array($id, arr($patient->power_ridge_inner));
                        $power_arm_attachment_inner = in_array($id, arr($patient->power_arm_attachment_inner));
                    @endphp
                    {{-- <div style="width:{{$lowerSize[$id]}}; height:18px; display:flex; align-items:center; justify-content:center;"> --}}
                    <div style="width:{{$lowerSize[$id]}};  display:flex; flex-direction: column; align-items:center; justify-content:flex-start; gap:6px;">

                         @if($power_ridge_inner)
                            <img src="{{ asset('public/assets/tooth/png/Power-Ridge.png') }}" style="width: 16px; height: 10px;" alt="Power Ridge Inner">
                        @endif

                        @if($power_arm_attachment_inner)
                            <img src="{{ asset('public/assets/tooth/png/Power-Arm-Attachment-lower.png') }}" style="width: 12px; height: 20px;" alt="Power Arm Attachment Inner">
                        @endif


                        @if($buttonInner)
                            <img src="{{ asset('public/assets/tooth/png/buttons.png') }}" style="width: 16px; height: 16px;" alt="Button Inner">
                        @endif

                        @if($ihookInner)
                            @if($id >=17 && $id <= 24)
                                <img src="{{ asset('public/assets/tooth/png/I-hook-LR.png') }}" style="width: 16px; height: 16px;" alt="I-Hook Inner">
                            @else
                                <img src="{{ asset('public/assets/tooth/png/I-hook-LL.png') }}" style="width: 16px; height: 16px;" alt="I-Hook Inner">
                            @endif
                        @endif

                        @if($precisionCutInner)
                            @if($id >=16 && $id <= 24)
                                <img src="{{ asset('public/assets/tooth/png/precisioncut-LR.png') }}" style="width: 16px; height: 16px;" alt="precisioncut Inner">
                            @else
                                <img src="{{ asset('public/assets/tooth/png/precisioncut-LL.png') }}" style="width: 16px; height: 16px;" alt="precisioncut Inner">
                            @endif
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
<br>
