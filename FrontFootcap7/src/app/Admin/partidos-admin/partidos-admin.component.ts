import { LoginService } from 'src/app/services/Loggin/login.service';
import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { CargardataService } from 'src/app/services/CargarDatos/cargardata.service';

@Component({
  selector: 'app-partidos-admin',
  templateUrl: './partidos-admin.component.html',
  styleUrls: ['./partidos-admin.component.css']
})
export class PartidosAdminComponent {


  partidos: any[] = [];
  isAdmin: boolean = false;

  constructor(private router: Router, private cargarDatos: CargardataService, private loginService: LoginService) {}

  ngOnInit(): void {
    this.cargarPartidos();
    this.isAdmin = this.loginService.getUserRole() === 'Admin';
  }

  cargarPartidos(): void {
    this.cargarDatos.cargarPartidosAdmin().subscribe(
      (data: any) => {
        this.partidos = data;
      },
      (error) => {
        console.error('Error al cargar los partidos:', error);
      }
    );
  }
}


