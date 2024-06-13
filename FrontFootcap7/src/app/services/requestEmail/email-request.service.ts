import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class EmailRequestService {

  constructor(private Http:HttpClient) {}


  //URL DEL ENDOPOINT

  URL='http://localhost:8000/reset_password';

//SERVICIO PARA OBTENER EL CORREO DEL USUARIO QUE PERDIO EL CORREO
  public request_Email(body:any){

    return this.Http.post(this.URL, body)
  }
}
