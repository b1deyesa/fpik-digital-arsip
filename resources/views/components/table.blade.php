<table class="table">
    @if ($head)
    <thead>
        <tr>
            {{ $head }}
        </tr>
    </thead>
    @endif
    @if ($head)
    <tbody>
        {{ $body }}
    </tbody>
    @endif
</table>