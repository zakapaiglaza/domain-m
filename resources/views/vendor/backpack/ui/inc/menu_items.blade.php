{{-- This file is used for menu items by any Backpack v7 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

@if(backpack_user()->can('domain-list'))
    <x-backpack::menu-item title="Domains" icon="la la-question" :link="backpack_url('domain')" />
@endif
