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

   // Cancelar reserva
   cancelarReserva(reservaId: number, data: any): Observable<any> {
    const url = `http://localhost:8000/reserva/${reservaId}/eliminar`;
    return this.http.delete(url, { body: data });
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

 // Editar reserva
 editarReserva(reservaId: number, canchaId: number, usuarioId: number, data: any): Observable<any> {
  const url = `http://localhost:8000/usuario/${usuarioId}/reserva/${reservaId}/cancha/${canchaId}/editar`;
  return this.http.put(url, data);
}
    // Obtener partidos del usuario
    obtenerPartidosUsuario(usuarioId: number): Observable<any> {
      const url = `http://localhost:8000/partidos/Usuario/${usuarioId}`;
      return this.http.get(url);
    }
}
