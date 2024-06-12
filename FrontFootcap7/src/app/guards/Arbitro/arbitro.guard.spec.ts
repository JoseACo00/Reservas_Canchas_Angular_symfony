import { TestBed } from '@angular/core/testing';

import { ArbitroGuard } from './arbitro.guard';

describe('ArbitroGuard', () => {
  let guard: ArbitroGuard;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    guard = TestBed.inject(ArbitroGuard);
  });

  it('should be created', () => {
    expect(guard).toBeTruthy();
  });
});
