import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'truncate'
})
export class TruncatePipe implements PipeTransform {

  transform(value: string, limit: number = 60, completeWords: boolean = true, ellipsis: string = '...'): string {

    if (!value) return '';
    if (value.length <= limit) return value;

    let truncated = value.substr(0, limit);

    if (completeWords) {
      const lastSpace = truncated.lastIndexOf(' ');
      if (lastSpace > 0) {
        truncated = truncated.substr(0, lastSpace);
      }
    }
    return truncated + ellipsis;
  }

}
