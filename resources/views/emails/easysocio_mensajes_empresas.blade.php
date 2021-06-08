@extends('emails.layouts.layout_nuevo')

{{--*/ $Color_principal  = '#4a9fff' /*--}}
{{--*/ $Color_fondo      = 'transparent'  /*--}}




@section('logo')
 <table class="es-header" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:{{$Color_fondo}};background-repeat:repeat;background-position:center top">
        <tbody>
         <tr style="border-collapse:collapse">
          <td align="center" style="padding:0;Margin:0">
           <table class="es-header-body" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px">
            <tbody>
             <tr style="border-collapse:collapse">
              <td align="left" style="Margin:0;padding-bottom:10px;padding-left:10px;padding-right:10px;padding-top:20px">
               <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                <tbody>
                 <tr style="border-collapse:collapse">
                  <td valign="top" align="center" style="padding:0;Margin:0;width:580px">
                   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                    <tbody>
                     <tr style="border-collapse:collapse">
                     <td align="center" style="Margin:0;padding-left:10px;padding-right:10px;padding-top:25px;padding-bottom:25px;font-size:0">
                        <a href="https://gestionsocios.com.uy">
                          <img src="https://app.gestionsocios.com.uy/imagenes/Empresa/logo_rectangular.png" alt="" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" width="190">
                        </a>
                      </td>
                     </tr>
                    </tbody>
                   </table></td>
                 </tr>
                </tbody>
               </table></td>
             </tr>
            </tbody>
           </table></td>
         </tr>
        </tbody>
       </table>
@stop

@section('titulo')
 <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
        <tbody>
         <tr style="border-collapse:collapse">
          <td style="padding:0;Margin:0;background-color:{{$Color_fondo}}" bgcolor="{{$Color_fondo}}" align="center">
           <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" cellspacing="0" cellpadding="0" align="center">
            <tbody>
             <tr style="border-collapse:collapse">
              <td align="left" style="padding:0;Margin:0">
               <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                <tbody>
                 <tr style="border-collapse:collapse">
                  <td valign="top" align="center" style="padding:0;Margin:0;width:600px">
                   <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:separate;border-spacing:0px;background-color:#FFFFFF;border-radius:4px" width="100%" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                    <tbody>

                    <tr style="border-collapse:collapse">
                      <td align="center" style="Margin:0;padding-bottom:5px;padding-left:30px;padding-right:30px;padding-top:35px">

                        <p style="Margin:0;line-height:30px;mso-line-height-rule:exactly;font-family:lato, 'helvetica neue', helvetica, arial, sans-serif;font-size:10px;font-style:normal;font-weight:normal;color:#999999"> Easysocio </p>

                      </td>
                     </tr>
                     <tr style="border-collapse:collapse">
                      <td align="center" style="Margin:0;padding-bottom:5px;padding-left:30px;padding-right:30px;padding-top:35px">

                        <h1 style="Margin:0;line-height:58px;mso-line-height-rule:exactly;font-family:lato, 'helvetica neue', helvetica, arial, sans-serif;font-size:32px;font-style:normal;font-weight:normal;color:#111111">{{$Data['subject']}}</h1>

                      </td>
                     </tr>
                     <tr style="border-collapse:collapse">
                      <td bgcolor="#ffffff" align="center" style="Margin:0;padding-top:5px;padding-bottom:5px;padding-left:20px;padding-right:20px;font-size:0">
                       <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                        <tbody>
                         <tr style="border-collapse:collapse">
                          <td style="padding:0;Margin:0px;border-bottom:1px solid #FFFFFF;background:#FFFFFFnone repeat scroll 0% 0%;height:1px;width:100%;margin:0px"></td>
                         </tr>
                        </tbody>
                       </table></td>
                     </tr>
                    </tbody>
                   </table></td>
                 </tr>
                </tbody>
               </table></td>
             </tr>
            </tbody>
           </table></td>
         </tr>
        </tbody>
       </table>


@stop



@section('contenido')

                     <tr style="border-collapse:collapse">
                      <td align="center"  class="es-m-txt-l" bgcolor="#ffffff" align="left" style="Margin:0;padding-top:20px;padding-bottom:20px;padding-left:30px;padding-right:30px">
                        <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:18px;font-family:lato, 'helvetica neue', helvetica, arial, sans-serif;line-height:27px;color:#666666">{{$Data['text']}}
                        </p>
                      </td>
                     </tr>

                     @if($Data['call_to_action'] != null || $Data['call_to_action'] != '')
                     <tr style="border-collapse:collapse">
                      <td align="center"  class="es-m-txt-l" bgcolor="#ffffff" align="left" style="Margin:0;padding-top:20px;padding-bottom:20px;padding-left:30px;padding-right:30px">
                        <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:18px;font-family:lato, 'helvetica neue', helvetica, arial, sans-serif;line-height:27px;color:#666666">
                        <a href="{{$Data['call_to_action_url']}}">
                        {{$Data['call_to_action']}}
                        </a>

                        </p>
                      </td>
                     </tr>
                     @endif

                     <tr style="border-collapse:collapse">
                      <td align="center"  class="es-m-txt-l" bgcolor="#ffffff" align="left" style="Margin:0;padding-top:20px;padding-bottom:20px;padding-left:30px;padding-right:30px">
                        <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:10x;font-family:lato, 'helvetica neue', helvetica, arial, sans-serif;line-height:27px;color:#666666">
                          Por cualquier duda o consulta podés comunicarte al celular +598 92 742 064 o bien responder este email.
                        </p>
                      </td>
                     </tr>

@stop



@section('footer')




  <tr style="border-collapse:collapse">
    <td align="center" style="padding:0;Margin:0">
      <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:12px;font-family:lato, 'helvetica neue', helvetica, arial, sans-serif;line-height:21px;color:#666666">

          Easysocio tu gestión Easy

      </p>
    </td>
  </tr>








@stop
