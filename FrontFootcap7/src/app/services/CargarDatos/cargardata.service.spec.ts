import { TestBed } from '@angular/core/testing';

import { CargardataService } from './cargardata.service';

describe('CargardataService', () => {
  let service: CargardataService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(CargardataService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
