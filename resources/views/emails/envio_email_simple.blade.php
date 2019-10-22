@extends('emails.layouts.layout_basico_para_mensajes')


@section('mensaje-texto')
   @if(isset($Texto))
    <tr>

        <td align="center" valign="top">

            <table class="rnb-del-min-width rnb-tmpl-width" width="100%" cellpadding="0" border="0" cellspacing="0" style="max-width:590px; " name="Layout_4" id="Layout_4">
                <tbody><tr>
                    <td class="rnb-del-min-width" align="center" valign="top" style="min-width:590px;">
                        <table width="100%" cellpadding="0" border="0" align="center" cellspacing="0" bgcolor="#f9fafc" style="padding-right: 20px; padding-left: 20px; background-color: rgb(249, 250, 252); table-layout:fixed;">
                            <tbody><tr>
                                <td height="20" style="font-size:1px; line-height:0px; mso-hide: all;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="font-size:14px; color:#888888; font-weight:normal; text-align:center; font-family:Arial,Helvetica,sans-serif; word-wrap:break-word;">
                                    {{$Texto}}
                                </td></tr>
                            <tr>
                                <td height="20" style="font-size:1px; line-height:0px; mso-hide: all;">&nbsp;</td>
                            </tr>
                           
                        </tbody></table>
                    </td>
                </tr>
            </tbody></table>
            </td>
    </tr>
    @endif

@endsection


@section('boton-llamada-accion-texto')

{{$Texto_boton}}
@endsection


@section('boton-llamada-accion-link')
{{$Link_del_boton}}

@endsection