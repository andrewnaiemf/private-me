<ul class="dropdown-menu" aria-labelledby="navbarDropdownLanguages">
@foreach(array_keys(config('locale.languages')) as $lang)
    @if($lang != app()->getLocale())
    <li><a href="{{ '/lang/'.$lang }}" class="dropdown-item">@lang('menus.language-picker.langs.'.$lang)</a></li>
    @endif
@endforeach
</ul>
