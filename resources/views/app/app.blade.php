<x-custom.app-layout2 :scrollspy="false">

    <x-slot:pageTitle>
        {{ $title }}
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite(['resources/scss/light/assets/components/list-group.scss'])
        @vite(['resources/scss/light/assets/widgets/modules-widgets.scss'])

        @vite(['resources/scss/dark/assets/components/list-group.scss'])
        @vite(['resources/scss/dark/assets/widgets/modules-widgets.scss'])
        <link rel="stylesheet" href="{{ asset('plugins-rtl/table/datatable/datatables.css') }}">
        {{-- @vite(['resources/rtl/scss/light/plugins/table/datatable/dt-global_style.scss']) --}}

        {{-- @vite(['resources/rtl/scss/dark/plugins/table/datatable/dt-global_style.scss']) --}}

        <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>

        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- Analytics -->

    <div class="row layout-top-spacing">

        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <x-custom.app.list-music title="Timeline Sekarang" />
            {{-- <x-dashboard._w-active-timeline title="Timeline Sekarang" :timelinesActive="$timelinesActive" />
            <x-dashboard._w-pagu title="Pagu Unit" :year="$year" :unitBudget="$unitBudget" link="javascript:void(0);" />
            <x-dashboard._w-waitinglist title="Waiting" :waitinglist="$waitinglist" /> --}}
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            <div id="videoContainer"></div>
        </div>
        @if (!empty($chartPagu['pagu']) && Auth::user()->hasRole(['SUPER ADMIN PERENCANAAN']))
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                {{-- <x-dashboard._w-chart :chartPagu="$chartPagu" :year="$year" title="Unique Visitors " /> --}}
            </div>
        @endif



        {{-- <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            <x-widgets._w-four title="Visitors by Browser" />
        </div> --}}

        {{-- <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
            <x-widgets._w-hybrid-one title="Followers" chart-id="hybrid_followers" />
        </div> --}}

        {{-- <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            <x-widgets._w-five title="Figma Design" />
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            <x-widgets._w-card-one title="Jimmy Turner" />
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            <x-widgets._w-card-two title="Dev Summit - New York" />
        </div> --}}

    </div>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        {{-- <script src="{{ asset('plugins/apex/apexcharts.min.js') }}"></script> --}}
        {{-- Analytics --}}
        @vite(['resources/assets/js/widgets/_wSix.js'])
        @vite(['resources/assets/js/widgets/_wChartThree.js'])
        @vite(['resources/assets/js/widgets/_wHybridOne.js'])
        @vite(['resources/assets/js/widgets/_wActivityFive.js'])
        <script src="{{ asset('plugins-rtl/table/datatable/datatables.js') }}"></script>
        <script src="{{ asset('plugins-rtl/table/datatable/button-ext/dataTables.buttons.min.js') }}"></script>

    </x-slot>
    </x-base-layout>
