import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';

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


   // Reservar cancha
   reservarCancha(usuarioId: number, canchaId: number, data: any): Observable<any> {
    const url = `http://localhost:8000/usuario/${usuarioId}/cancha/${canchaId}/reservarCancha`;
    return this.http.post(url, data);
  }

  // Obtener reservas del usuario
  obtenerReservasUsuario(usuarioId: number): Observable<any> {
    const url = `http://localhost:8000/usuario/${usuarioId}/reservas`;
    return this.http.get(url);
  }
}
