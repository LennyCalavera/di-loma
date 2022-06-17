<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('root') }}" class="nav-link {{ Request::is('root') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>На главную</p>
    </a>
</li>
<li class="{{ Request::is('terms*') ? 'active' : '' }}">
    <a href="{{ route('terms.index') }}"><i class="fa fa-edit"></i><span>Terms</span></a>
</li>

<li class="{{ Request::is('symptoms*') ? 'active' : '' }}">
    <a href="{{ route('symptoms.index') }}"><i class="fa fa-edit"></i><span>Symptoms</span></a>
</li>

<li class="{{ Request::is('diseases*') ? 'active' : '' }}">
    <a href="{{ route('diseases.index') }}"><i class="fa fa-edit"></i><span>Diseases</span></a>
</li>

<li class="{{ Request::is('rules*') ? 'active' : '' }}">
    <a href="{{ route('rules.index') }}"><i class="fa fa-edit"></i><span>Rules</span></a>
</li>

