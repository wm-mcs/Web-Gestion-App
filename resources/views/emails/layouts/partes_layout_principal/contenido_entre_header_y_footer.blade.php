<tr valign="top" align="center">
  <td width="600px" bgcolor="#ffffff">
    <table>
      <tbody>
        <tr>
          <td width="40px"></td>
            <td width="520px">
              <table>
                <tbody>
                  <tr height="40px"><td></td></tr>
                    {{-- texto de para user --}}
                    <tr height="50px">
                      <td width="100%" valign="top" align="left" style="font-family:Verdana, Helvetica, Arial, sans-serif; color:#858585; font-size:20px">
                        @yield('texto_a_user_email')
                      </td>
                    </tr>
                    <tr>
                      <td width="100%" valign="top" align="left" style="font-family:Verdana, Helvetica, Arial, sans-serif; color:#b3b3b3; font-size:16px">
                        @yield('mensaje_email')                        
                      </td>
                    </tr>
                    <tr height="40px"><td></td></tr>
                    <tr>
                     <td>
                      <table>
                       <tbody>
                        <tr height="40px" align="center">
                         <td width="155px"></td>
                          <td width="210px" style="font-family:Verdana, Helvetica, Arial, sans-serif; color:#FFFFFF; font-size:22px;border-bottom-left-radius:5px;border-bottom-right-radius:5px;border-top-left-radius:5px;border-top-right-radius:5px" valign="center" align="center" bgcolor="#4a9fff">
                            <a href="@yield('url_email')" style="color:#FFFFFF;">
                              <div width="100%" height="100%">
                                {{-- boton texto --}}
                                @yield('boton_texto_email')
                              </div>
                            </a>
                          </td>
                          <td width="155px"></td>
                        </tr>
                       </tbody>
                      </table>
                     </td>
                    </tr>
                    <tr height="60px"><td></td></tr>
                    <tr>
                      <td width="100%" valign="top" align="left" style="font-family:Verdana, Helvetica, Arial, sans-serif; color:#b3b3b3; font-size:12px">
                        @yield('mensaje_secundario_email')                        
                      </td>
                    </tr>
                    <tr height="40px"><td></td></tr>
                  </tbody>
                </table>
              </td>
              <td width="40px"></td>
            </tr>
          </tbody>
        </table>
       </td>
     </tr> 