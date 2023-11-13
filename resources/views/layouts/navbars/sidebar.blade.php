<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="#" class="simple-text logo-mini"><i class="fas fa-home"></i></a>
            <a href="#" class="simple-text logo-normal">{{ __('Dashboard') }}</a>
        </div>
        <ul class="nav">
            <li @if ($pageSlug=='show' ) class="active " @endif>
                <a href="{{ route('match.menu') }}">
                    <i class="fas fa-chess-knight"></i>
                    <p>{{ __('Start Match') }}</p>
                </a>
            </li>
            <!-- <li @if ($pageSlug=='notifications' ) class="active " @endif>
                <a href="{{ route('pages.notifications') }}">
                    <i class="tim-icons icon-bell-55"></i>
                    <p>{{ __('Notifications') }}</p>
                </a>
            </li> -->
            <li @if ($pageSlug=='contactMessages' ) class="active " @endif>
                <a href="{{ route('contact.getAllContacts') }}">
                    <i class="far fa-envelope-open"></i>
                    <p>{{ __('Contact Messages') }}</p>
                </a>
            </li>
            <li @if ($pageSlug=='contact' ) class="active " @endif>
                <a href="{{ route('contact.index') }}">
                    <i class="fas fa-comment-alt"></i>
                    <p>{{ __('Contact Us') }}</p>
                </a>
            </li>
        </ul>
    </div>
</div>