import { AdminService } from 'src/app/services/Admin/admin.service';
import { CargardataService } from './../../services/CargarDatos/cargardata.service';
import { Component, OnInit } from '@angular/core';
import { FormBuilder } from '@angular/forms';
import { Route, Router } from '@angular/router';
import { LoginService } from 'src/app/services/Loggin/login.service';
import * as bootstrap from 'bootstrap';
@Component({
  selector: 'app-canchas',
  templateUrl: './canchas.component.html',
  styleUrls: ['./canchas.component.css']
})
export class CanchasComponent  implements OnInit{
[x: string]: any;

  canchas: any[] = [];
  isAdmin: boolean = false;
  isUser: boolean = false;
  canchaIdToDelete: number | null = null;
  constructor(private router: Router, private cargarDatos: CargardataService, private LoginService: LoginService, private adminservice: AdminService){
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

  reservarCancha(id: number) {
    this.router.navigate(['/Reservar/Cancha', id]);
  }

  openDeleteModal(canchaId: number): void {
    this.canchaIdToDelete = canchaId;
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
      const modalInstance = new bootstrap.Modal(deleteModal);
      modalInstance.show();
    }
  }

  confirmDelete(): void {
    if (this.canchaIdToDelete !== null) {
      this.adminservice.eliminarCancha(this.canchaIdToDelete).subscribe(
        res => {
          console.log('Cancha eliminada:', res);
          this.cargarCanchas(); // Recargar la lista de canchas
          const deleteModal = document.getElementById('deleteModal');
          if (deleteModal) {
            const modalInstance = bootstrap.Modal.getInstance(deleteModal);
            if (modalInstance) {
              modalInstance.hide();
            }
          }
        },
        error => {
          console.error('Error al eliminar la cancha:', error);
        }
      );
    }
  }





}
