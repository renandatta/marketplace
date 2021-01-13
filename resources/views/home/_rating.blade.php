<div class="rating__body">
    @for($i = 1; $i <= $rating; $i++)
        <i class="fa fa-star" style="color: #ffd333"></i>
    @endfor
    @for($i = $rating; $i < 5; $i++)
        <i class="fa fa-star" style="color: #eaeaea"></i>
    @endfor
</div>
