@extends('layouts.app_base_horizontal')


@section('css')
<style>
    .jaws-price {
        min-width: 100px !important;
    }
</style>
@stop

@section('content')

<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18">Settings</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Tiers</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

<div class="row">
    <div class="col-12">
        <div class="card mb-3">

            <div class="card-body ">
                <div class="table-rep-plugin">
                    <div class="table-responsive mb-0" data-pattern="priority-columns">
                        <table id="tech-companies-1" class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col" style="min-width: 150px;"></th>
                                <th scope="col" colspan="2">SECRET&reg; Smart Select 10</th>
                                <th scope="col" colspan="2">SECRET&reg; Smart Select 20</th>
                                <th scope="col" colspan="2">SECRET&reg; Smart Select 30</th>
                                <th scope="col" colspan="2">SECRET&reg; Smart Select &infin;</th>
                                <th scope="col" colspan="2">SECRET&reg; Confidence</th>
                            </tr>
                            <tr>
                                <th scope="col"><strong>Tier</strong></th>
                                <th scope="col" width="250px">Single</th>
                                <th scope="col" width="250px">Dual</th>
                                <th scope="col" width="250px">Single</th>
                                <th scope="col" width="250px">Dual</th>
                                <th scope="col" width="250px">Single</th>
                                <th scope="col" width="250px">Dual</th>
                                <th scope="col" width="250px">Single</th>
                                <th scope="col" width="250px">Dual</th>
                                <th scope="col" width="250px">Dual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tiers as $tier)
                                <tr>
                                    <td>{{ $tier->tier_name == 'None' ? '' : $tier->tier_name }}</td>
                                    <td>
                                        <div class="input-group mb- 3 flex-nowrap"><span class="input-group-text">€</span>
                                            <input class="form-control jaws-price" tier="{{ $tier->id }}"
                                                column="one_jaw_price_10" value="{{ intval($tier->one_jaw_price_10) }}"
                                                type="text" aria-label="Amount (to the nearest dollar)" /><span
                                                class="input-group-text">.00</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group mb- 3 flex-nowrap"><span class="input-group-text">€</span>
                                            <input class="form-control jaws-price" tier="{{ $tier->id }}"
                                                column="two_jaw_price_10" value="{{ intval($tier->two_jaw_price_10) }}"
                                                type="text" aria-label="Amount (to the nearest dollar)" /><span
                                                class="input-group-text">.00</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group mb- 3 flex-nowrap"><span class="input-group-text">€</span>
                                            <input class="form-control jaws-price" tier="{{ $tier->id }}"
                                                column="one_jaw_price_20" value="{{ intval($tier->one_jaw_price_20) }}"
                                                type="text" aria-label="Amount (to the nearest dollar)" /><span
                                                class="input-group-text">.00</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group mb- 3 flex-nowrap"><span class="input-group-text">€</span>
                                            <input class="form-control jaws-price" tier="{{ $tier->id }}"
                                                column="two_jaw_price_20" value="{{ intval($tier->two_jaw_price_20) }}"
                                                type="text" aria-label="Amount (to the nearest dollar)" /><span
                                                class="input-group-text">.00</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group mb- 3 flex-nowrap"><span class="input-group-text">€</span>
                                            <input class="form-control jaws-price" tier="{{ $tier->id }}"
                                                column="one_jaw_price_30" value="{{ intval($tier->one_jaw_price_30) }}"
                                                type="text" aria-label="Amount (to the nearest dollar)" /><span
                                                class="input-group-text">.00</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group mb- 3 flex-nowrap"><span class="input-group-text">€</span>
                                            <input class="form-control jaws-price" tier="{{ $tier->id }}"
                                                column="two_jaw_price_30" value="{{ intval($tier->two_jaw_price_30) }}"
                                                type="text" aria-label="Amount (to the nearest dollar)" /><span
                                                class="input-group-text">.00</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group mb- 3 flex-nowrap"><span class="input-group-text">€</span>
                                            <input class="form-control jaws-price" tier="{{ $tier->id }}"
                                                column="one_jaw_price_infinite"
                                                value="{{ intval($tier->one_jaw_price_infinite) }}" type="text"
                                                aria-label="Amount (to the nearest dollar)" /><span
                                                class="input-group-text">.00</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group mb- 3 flex-nowrap"><span class="input-group-text">€</span>
                                            <input class="form-control jaws-price" tier="{{ $tier->id }}"
                                                column="two_jaw_price_infinite"
                                                value="{{ intval($tier->two_jaw_price_infinite) }}" type="text"
                                                aria-label="Amount (to the nearest dollar)" /><span
                                                class="input-group-text">.00</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group mb- 3 flex-nowrap"><span class="input-group-text">€</span>
                                            <input class="form-control jaws-price" tier="{{ $tier->id }}"
                                                column="two_jaw_price_confidence"
                                                value="{{ intval($tier->two_jaw_price_confidence) }}" type="text"
                                                aria-label="Amount (to the nearest dollar)" /><span
                                                class="input-group-text">.00</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                </div>
            </div>
        </div>
    </div>
</div>

</div>



    <form id="delete-user" method="POST">
        @csrf()
    </form>
@stop

@section('javascript')
    @include('layouts.page_scripts')
    <script>
        $(document).ready(function() {
            $(document).on('change', '.jaws-price', function() {
                var column = $(this).attr('column');
                var price = parseInt($(this).val());
                var tier = $(this).attr('tier');
                console.log(price)
                if (price > 0 && price != '' && price != undefined && price != NaN) {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/tier-settings/change-price') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "jaw": column,
                            "price": price,
                            "tier": tier,
                        },
                    }).done(function(response) {
                        if (response.status == 200) {
                            toastSuccess("Changes Saved!");
                        } else {
                            toastError("Enable to save changes!");
                        }
                    }).fail(function(response) {
                        toastError("Enable to save changes!");
                    });
                } else {
                    toastError("Enter valid price!");
                }
            });
        })
    </script>
@stop
