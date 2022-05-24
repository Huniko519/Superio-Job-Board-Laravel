<div class="marker-container">
    <div class="marker-card">
        <div class="front face">
            <div style="background-image: url({{ get_file_url($row->user->avatar_id) ?? asset('images/avatar.png') }}"></div>
        </div>
        <div class="back face">
            <div style="background-image: url({{ get_file_url($row->user->avatar_id) ?? asset('images/avatar.png') }}"></div>
        </div>
        <div class="marker-arrow"></div>
    </div>
</div>
