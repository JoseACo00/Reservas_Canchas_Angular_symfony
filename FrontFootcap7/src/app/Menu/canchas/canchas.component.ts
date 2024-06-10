import { CargardataService } from './../../services/CargarDatos/cargardata.service';
import { Component, OnInit } from '@angular/core';
import { FormBuilder } from '@angular/forms';
import { Route, Router } from '@angular/router';
import { LoginService } from 'src/app/services/Loggin/login.service';

@Component({
  selector: 'app-canchas',
  templateUrl: './canchas.component.html',
  styleUrls: ['./canchas.component.css']
})
export class CanchasComponent  implements OnInit{

  canchas: any[] = [];
  isAdmin: boolean = false;
  isUser: boolean = false;

  constructor(private router: Router, private cargarDatos: CargardataService, private LoginService: LoginService,){
  }
  ngOnInit() {
    this.cargarCanchas();
    this.isAdmin = this.LoginService.getUserRole() === 'Admin';
    this.isUser = this.LoginService.getUserRole() === 'Usuario';
  }


  cargarCanchas() {
    this.cargarDatos.cargarCanchas().subscribe(
      (data: any) => {
        this.canchas = data;
      },
      (error) => {
        console.error('Error al cargar las canchas:', error);
      }
    );
  }

  editarCancha(id: number) {
    this.router.navigate(['/Editar/Cancha', id]);
  }


  // ngOnInit(): void {
  //   this.cargarDatos.cargarCanchas().subscribe(data => {
  //     this.canchas = data;
  //   }, error => {
  //     console.error('Error al cargar las canchas', error);
  //   });
  // }





}
