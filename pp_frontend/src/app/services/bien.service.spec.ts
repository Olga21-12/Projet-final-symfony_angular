import { TestBed } from '@angular/core/testing';

import { BienService } from './bien.service';

describe('BienService', () => {
  let service: BienService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(BienService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
