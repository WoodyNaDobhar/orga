<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('archetypes.index') }}" class="nav-link {{ Request::is('archetypes*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Archetypes</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('attendances.index') }}" class="nav-link {{ Request::is('attendances*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Attendances</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('awards.index') }}" class="nav-link {{ Request::is('awards*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Awards</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('configurations.index') }}" class="nav-link {{ Request::is('configurations*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Configurations</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('dues.index') }}" class="nav-link {{ Request::is('dues*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Dues</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('events.index') }}" class="nav-link {{ Request::is('events*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Events</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('issuances.index') }}" class="nav-link {{ Request::is('issuances*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Issuances</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('kingdoms.index') }}" class="nav-link {{ Request::is('kingdoms*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Kingdoms</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('kingdomOffices.index') }}" class="nav-link {{ Request::is('kingdomOffices*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Kingdom Offices</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('kingdomTitles.index') }}" class="nav-link {{ Request::is('kingdomTitles*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Kingdom Titles</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('locations.index') }}" class="nav-link {{ Request::is('locations*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Locations</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('meetups.index') }}" class="nav-link {{ Request::is('meetups*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Meetups</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('members.index') }}" class="nav-link {{ Request::is('members*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Members</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('officers.index') }}" class="nav-link {{ Request::is('officers*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Officers</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('offices.index') }}" class="nav-link {{ Request::is('offices*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Offices</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('parkranks.index') }}" class="nav-link {{ Request::is('parkranks*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Parkranks</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('parks.index') }}" class="nav-link {{ Request::is('parks*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Parks</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('pronouns.index') }}" class="nav-link {{ Request::is('pronouns*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Pronouns</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('recommendations.index') }}" class="nav-link {{ Request::is('recommendations*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Recommendations</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('reconciliations.index') }}" class="nav-link {{ Request::is('reconciliations*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Reconciliations</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('splits.index') }}" class="nav-link {{ Request::is('splits*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Splits</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('suspensions.index') }}" class="nav-link {{ Request::is('suspensions*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Suspensions</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('titles.index') }}" class="nav-link {{ Request::is('titles*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Titles</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('tournaments.index') }}" class="nav-link {{ Request::is('tournaments*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Tournaments</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('transactions.index') }}" class="nav-link {{ Request::is('transactions*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Transactions</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('units.index') }}" class="nav-link {{ Request::is('units*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Units</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('users.index') }}" class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Users</p>
    </a>
</li>
