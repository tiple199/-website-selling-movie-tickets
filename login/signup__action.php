<%
    username = Request.Form("txtusername")
    password = Request.Form("txtpassword")
    address = Request.Form("txtaddress")
    email = Request.Form("txtemail")
    phone = Request.Form("txtphone")

    set conn = Server.CreateObject("ADODB.Connection")
    set rs = Server.CreateObject("ADODB.Recordset")
    strconn = "Provider=Microsoft.Jet.OLEDB.4.0;Data Source=" & Server.Mappath("Datalogin.mdb")
    conn.Open strconn

    sql = "INSERT INTO [user] ([username] , [password],level__id,[address],[email],[phone],status) VALUES ('" & username & "','"& password & "'," & 2 &",'" & address &"','" &  email &"','" & phone &"'," & 1 &")"

    sql_check = "select * from [user] where username = '" & username &"';"
    rs.open sql_check, conn
    if rs.eof then 
        conn.execute sql
        session("login_error") = "Add new suscess"
        response.redirect("login.asp")
    else 
        session("login_error") = "Add new failed because username exist"
        response.redirect("signup.asp")
    End if
    rs.close
    conn.close

%>
