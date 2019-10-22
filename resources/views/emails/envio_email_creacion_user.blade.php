@extends('emails.layouts.layout_basico_para_mensajes')


@section('mensaje-texto')
   @if(isset($Texto))
    <tr>

        <td align="center" valign="top">

            <table class="rnb-del-min-width rnb-tmpl-width" width="100%" cellpadding="0" border="0" cellspacing="0" style="max-width:590px; " name="Layout_4" id="Layout_4">
                <tbody><tr>
                    <td class="rnb-del-min-width" align="center" valign="top" style="min-width:590px;">
                        <table width="80%" cellpadding="0" border="0" align="center" cellspacing="0" bgcolor="#f9fafc" style="padding-right: 20px; padding-left: 20px; background-color: rgb(249, 250, 252); table-layout:fixed;">
                            <tbody>
                            <tr>
                                <td height="40" style="font-size:1px; line-height:0px; mso-hide: all;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="font-size:14px; color:#888888; font-weight:normal; text-align:center; font-family:Arial,Helvetica,sans-serif; word-wrap:break-word;">
                                    {{$Texto}}
                                </td>
                               
                            </tr>
                             <tr>
                                <td height="20" style="font-size:1px; line-height:0px; mso-hide: all;">&nbsp;</td>
                            </tr>
                            <tr>
                             <td style="font-size:14px; color:#888888; font-weight:normal; text-align:center; font-family:Arial,Helvetica,sans-serif; word-wrap:break-word;">
                                    Tu usuario es:  <strong>{{$User_name}}</strong>
                                </td>
                             </tr>
                             <tr>
                                <td height="20" style="font-size:1px; line-height:0px; mso-hide: all;">&nbsp;</td>
                            </tr>
                             <tr>
                                <td style="font-size:14px; color:#888888; font-weight:normal; text-align:center; font-family:Arial,Helvetica,sans-serif; word-wrap:break-word;">
                                    Tu contraseña es: <strong>{{$Contraseña}}</strong>  (la podrás cambiar)
                                </td>
                             </tr>
                            <tr>
                                <td height="80" style="font-size:1px; line-height:0px; mso-hide: all;">&nbsp;</td>
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


<tr>

        <td align="center" valign="top">

            <table class="rnb-del-min-width rnb-tmpl-width" width="100%" cellpadding="0" border="0" cellspacing="0" style="min-width:590px;" name="Layout_26" id="Layout_26">
                <tbody><tr>
                    <td class="rnb-del-min-width" valign="top" align="center" style="min-width: 590px;">
                        <table width="100%" cellpadding="0" border="0" bgcolor="#f9fafc" align="center" cellspacing="0" style="background-color: rgb(249, 250, 252);">
                            <tbody><tr>
                                <td height="30" style="font-size:1px; line-height:0px; mso-hide: all;">&nbsp;</td>
                            </tr>
                             <tr>
                              <a href="{{$Link_del_boton}}" style="text-decoration: none; ">
                                <div style="padding: 20px; border-radius:6px; background-color:#ff5a5f; color:white; border-bottom:solid 3px #ff7377; width: 150px; font-family:Arial,Helvetica,sans-serif; font-size: 16px;">
                                  {{$Texto_boton}}
                                </div>
                              </a>
                            </tr>
                            <tr>
                                <td height="30" style="font-size:1px; line-height:0px; mso-hide: all;">&nbsp;</td>
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
            </tbody></table>
            </td>
    </tr>

@endsection


