import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PartidosUsuarioComponent } from './partidos-usuario.component';

describe('PartidosUsuarioComponent', () => {
  let component: PartidosUsuarioComponent;
  let fixture: ComponentFixture<PartidosUsuarioComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ PartidosUsuarioComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(PartidosUsuarioComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
