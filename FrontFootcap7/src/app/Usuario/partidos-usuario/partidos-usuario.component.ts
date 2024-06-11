import { Component } from '@angular/core';
import { LoginService } from 'src/app/services/Loggin/login.service';
import { UsuarioService } from 'src/app/services/User/usuario.service';

@Component({
  selector: 'app-partidos-usuario',
  templateUrl: './partidos-usuario.component.html',
  styleUrls: ['./partidos-usuario.component.css']
})
export class PartidosUsuarioComponent {

  partidos: any[] = [];
  usuarioId: number | null = null;

  constructor(private usuarioService: UsuarioService, private loginService: LoginService) { }

  ngOnInit(): void {
    this.usuarioId = this.loginService.getUserId(); // Obtener el ID del usuario del JWT
    if (this.usuarioId) {
      this.cargarPartidos(this.usuarioId);
    }
  }

  cargarPartidos(usuarioId: number): void {
    this.usuarioService.obtenerPartidosUsuario(usuarioId).subscribe(
      (data: any) => {
        this.partidos = data;
      },
      (error) => {
        console.error('Error al cargar los partidos:', error);
      }
    );
  }
}
