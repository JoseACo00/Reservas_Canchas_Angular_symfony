import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class UsuarioService {

  constructor(private http: HttpClient) { }



  //EndPoint de la api de symfony para registar usuario
  createUserURl='http://localhost:8000/registrarUsuario';

  //Funcion para creare  mandar los datos en Formato Json y el back registra el usaurio
  public registrarUsuario(data: any){
    return this.http.post(this.createUserURl,data);
  }
}
