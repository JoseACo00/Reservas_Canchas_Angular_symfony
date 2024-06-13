import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { ArbitroService } from 'src/app/services/Arbitro/arbitro.service';
import { LoginService } from 'src/app/services/Loggin/login.service';

@Component({
  selector: 'app-partidos-arbitro',
  templateUrl: './partidos-arbitro.component.html',
  styleUrls: ['./partidos-arbitro.component.css']
})
export class PartidosArbitroComponent {


  arbitroId!: number;
  partidos: any[] = [];

  constructor(
    private arbitroService: ArbitroService,
    private loginService: LoginService,
    private router: Router
  ) {}

  ngOnInit(): void {
    const userId = this.loginService.getUserId();
    if (userId === null) {
      // Manejar el caso en el que el userId no está disponible
      console.error('No se pudo obtener el ID del árbitro');
      this.router.navigate(['/Login']);
      return;
    }

    this.arbitroId = userId;
    this.cargarPartidos();
  }

  cargarPartidos(): void {
    this.arbitroService.obtenerPartidosArbitro(this.arbitroId).subscribe(
      (data: any) => {
        this.partidos = data;
      },
      (error) => {
        console.error('Error al cargar los partidos:', error);
      }
    );
  }

  actualizarEstado(partidoId: number, estado: string): void {
    const data = { estado_arbitro: estado };
    this.arbitroService.actualizarEstadoArbitro(partidoId, data).subscribe(
      res => {
        console.log('Estado del árbitro actualizado:', res);
        this.cargarPartidos(); // Recargar la lista de partidos
      },
      error => {
        console.error('Error al actualizar el estado del árbitro:', error);
      }
    );
  }
}
