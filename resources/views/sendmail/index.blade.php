<?php

use App\Helpers\Menu;
$logo = Menu::get_logo();
?>
<link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600&display=swap" rel="stylesheet"/>
<style>
    html,body { padding: 0; margin:0; font-family:"Segoe UI", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;}
</style>

<div style="font-family:'Segoe UI',sans-serif; line-height: 1.5; font-weight: normal; font-size: 15px; color: #2F3044; min-height: 100%; margin:0; padding:0; width:100%; background-color:#f8f7fa">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;margin:0 auto; padding:0; max-width:40rem">
        <tbody>
        <tr>
            <td align="center" valign="center" style="text-align:center; padding: 40px">
                <a href="#" rel="noopener" target="_blank">
                    <?php if (isset($logo->logo_logo)){ ?>
                    <img alt="Logo" src="{{ asset('/frontend/logo/'. @$logo->logo_logo)}}"
                         style="margin:5px; padding: 5px"/>
                    <?php } ?>
                </a>
            </td>
        </tr>
        <tr>
            <td align="left" valign="center">
                <div style="margin: 10px 10px; padding: 40px; background-color:#ffffff; border-radius: 6px">
                    <!--begin:Email content-->
                    <div style="padding-bottom: 5px;">
                        <h3 style="font-size: 1.375rem;line-height: 1.37;">
                            <strong style="color:#5d596c">
                                {{@$data['titre']}}
                            </strong>
                        </h3>
                    </div>
                    <div style="padding-bottom: 30px;">
                        <p style="font-weight: 500;font-size: 0.9375rem;line-height: 1.37; color:#5d596c">
                            {!! @$data['messages'] !!}
                        </p>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td align="center" valign="center" style="font-size: 13px; text-align:center;padding: 20px; color: #6d6e7c;">
                <p>Copyright ©
                    @php
                        $year = date("Y");
                    @endphp
                    @isset($year)
                        {{$year}}
                    @endisset
                    FDFP. Tous droits reservés.</p>
            </td>
        </tr></br>
        </tbody>
    </table>
</div>
