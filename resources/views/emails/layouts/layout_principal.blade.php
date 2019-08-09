<table width="100%" cellspacing="0" cellpadding="0" border="0">
 <tbody>
  <tr>
   <td bgcolor="#b3b3b3" valign="top" align="center">
     <table width="600px" cellspacing="0" cellpadding="0" border="0">
      <tbody>     

       <!-- header del email -->
       @include('emails.layouts.partes_layout_principal.header')
        
       <tr height="10px"><td width="100%" bgcolor="#4a9fff"></td></tr>

       <!-- contenido para extender del email -->
       @include('emails.layouts.partes_layout_principal.contenido_entre_header_y_footer')

       <!-- Footer del Email -->       
       @include('emails.layouts.partes_layout_principal.footer')
       
      </tbody>
     </table>
   </td>
  </tr>
 </tbody>
</table>

