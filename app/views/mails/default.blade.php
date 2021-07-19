@extends('layouts.main',
[
  'title' => $header ?? '',
  'language' => 'en'
])

@section('content')

@if(isset($sections))

  @foreach ($sections as $section)
      
  <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
    <tr>
      <td bgcolor="{{ $section['background'] ?? '#ffffff' }}" align="center" style="padding: 70px 15px 70px 15px;" class="section-padding">
        <table style="max-width: {{ $section['maxwidth'] ?? '600px' }}" width="100%" border="0" cellspacing="0" cellpadding="0">
        
          @if(isset($section['image']))
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0"><tbody><tr><td class="padding-copy"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td>
                  <a href="#" target="_blank" style="text-align:center;">
                    <img src="' . $args['image'] . '" width="500" height="200" border="0" alt="Can an email really be responsive?" style="object-fit: contain;display: block; padding: 0; color: #666666; text-decoration: none; font-family: Helvetica, arial, sans-serif; font-size: 16px; width: 500px; height: 200px;" class="img-max">
                  </a>
                </td></tr></table></td></tr></tbody></table>
              </td>
            </tr>
          @endif

          <tr>
            <td>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                @if(isset($section['header']))
                  <tr>
                    <td align="center" style="font-size: 25px; font-family: Helvetica, Arial, sans-serif; color: #333333; padding-top: 30px;" class="padding-copy">
                      {{ $section['header'] }}
                    </td>
                  </tr>
                @endif

                <tr>
                  <td align="center" style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">
                    {{ $section['message'] }}
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          
          @if(isset($section['buttons']) && is_array($section['buttons']))
            <tr><td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="mobile-button-container"><tr><td align="center" style="padding: 25px 0 0 0;" class="padding-copy"><table border="0" cellspacing="0" cellpadding="0" class="responsive-table">
              
              @foreach ($section['buttons'] as $button)
              <tr>
                <td align="center">
                  <a href="{{ $button['url'] }}" target="_blank" style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #ffffff; text-decoration: none; background-color: {{ $button['color'] ?? '#f8f8f8' }}; border-top: 15px solid {{ $button['color'] ?? '#f8f8f8' }}; border-bottom: 15px solid {{ $button['color'] ?? '#f8f8f8' }}; border-left: 25px solid {{ $button['color'] ?? '#f8f8f8' }}; border-right: 25px solid {{ $button['color'] ?? '#f8f8f8' }}; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; display: inline-block;" class="mobile-button">
                    {{ $button['name'] }}
                  </a>
                </td>
              </tr>
              @endforeach
            
            </table></td></tr></table></td></tr>
          @endif

        </table></td></tr></table>

  @endforeach

@endif

@endsection