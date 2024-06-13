import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';


@Injectable({
  providedIn: 'root'
})
export class ChangepasswordService {


  constructor(private http: HttpClient) { }


  baseUrl = 'http://localhost:8000';

   // Método para cambiar la contraseña
   public changePassword(token: string, body: any) {
    // Construir la URL completa con el token
    const url = `${this.baseUrl}/reset-password/${token}`;
    // Realizar la solicitud POST a la URL construida
    return this.http.post(url, body);
  }

}
