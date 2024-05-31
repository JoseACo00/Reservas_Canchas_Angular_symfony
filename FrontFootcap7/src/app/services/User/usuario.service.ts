import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class UsuarioService {

  constructor(private http: HttpClient) { }



  //EndPoint de la api de symfony para registrar usuario
createUserURl='http://192.168.1.35:8000/registrarUsuario';

//Funcion para crear y mandar los datos en formato JSON y el back registra el usuario
public registrarUsuario(data: any){
  return this.http.post(this.createUserURl, data);
}

}
