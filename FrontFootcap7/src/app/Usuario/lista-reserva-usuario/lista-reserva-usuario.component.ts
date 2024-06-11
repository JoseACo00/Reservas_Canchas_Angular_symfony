import { Component } from '@angular/core';
import { LoginService } from 'src/app/services/Loggin/login.service';
import { UsuarioService } from 'src/app/services/User/usuario.service';

@Component({
  selector: 'app-lista-reserva-usuario',
  templateUrl: './lista-reserva-usuario.component.html',
  styleUrls: ['./lista-reserva-usuario.component.css']
})
export class ListaReservaUsuarioComponent {

  reservas: any[] = [];
  usuarioId: number | null = null;

  constructor(private usuarioService: UsuarioService, private loginService: LoginService) { }


  ngOnInit(): void {
    this.usuarioId = this.loginService.getUserId(); // Obtener el ID del usuario del JWT
    if (this.usuarioId) {
      this.cargarReservas(this.usuarioId);
    }
  }

  cargarReservas(usuarioId: number): void {
    this.usuarioService.obtenerReservasUsuario(usuarioId).subscribe(
      (data: any) => {
        this.reservas = data;
      },
      (error) => {
        console.error('Error al cargar las reservas:', error);
      }
    );
  }
}

