
<section class="container notifications">
    @forelse ($notifications as $notification)
        <div role="alert" @class([
            'alert',
            'alert-primary' => ($notification['type'] ?? '') === 'primary',
            'alert-secondary' => in_array(($notification['type'] ?? ''), ['secondary', ''], true),
            'alert-warning' => ($notification['type'] ?? '') === 'warning',
            'alert-success' => ($notification['type'] ?? '') === 'success',
            'alert-danger' => ($notification['type'] ?? '') === 'danger',
            'alert-info' => ($notification['type'] ?? '') === 'info',
            'alert-light' => ($notification['type'] ?? '') === 'light',
            'alert-dismissible',
            'fade',
            'show',
            'shadow',
            'sm:rounded-lg',
        ])>
            @isset($notification['head'])
                <h4 class="alert-heading">{{ $notification['head'] }}</h4>
            @endisset
            <ul>
                @forelse ($notification['messages'] as $message)
                    <li>{!! $message['text'] !!}</li>
                @empty
                    <li>No message to show.</li>
                @endforelse
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
        </div>
    @empty
        <div role="alert" class="alert alert-secondary alert-dismissible fade show">
            <ul>
                <li>No notification to show.</li>
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endforelse
</section>
