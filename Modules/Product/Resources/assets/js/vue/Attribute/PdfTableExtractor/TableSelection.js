class TableSelection {

  constructor() {
    this.$selection = undefined;
    $(document)
      .on('selectionchange', this.select.bind(this))
      .on('copy', this.clipboardCopyHandler.bind(this));

    $(window).on('blur', this.deselect.bind(this))
  }

  select() {
    // Clear previous selection
    this.$selection && this.$selection.removeClass('selected');

    // Get current selection
    var selection = window.getSelection ? getSelection() : null;
    if (!selection || !selection.anchorNode || !$(selection.anchorNode).parents('.table-selection').length) {
      return;
    }

    // Get cell / row refs
    var $startCell = $(selection.anchorNode).closest('td'),
      $endCell = $(selection.focusNode).closest('td'),
      $startRow = $startCell.closest('tr'),
      $endRow = $endCell.closest('tr'),
      $tbody = $startRow.closest('tbody');

    // Normalize to allow all directions
    var startCellIndex = Math.min($startCell.index(), $endCell.index()),
      endCellIndex = Math.max($startCell.index(), $endCell.index()),
      startRowIndex = Math.min($startRow.index(), $endRow.index()),
      endRowIndex = Math.max($startRow.index(), $endRow.index());

    // Get elements in current selection
    this.$selection = $(null);
    let _this = this
    $tbody
      .find('tr')
      .slice(startRowIndex, endRowIndex + 1)
      .each(function () {
        _this.$selection = _this.$selection.add(
          $(this)
            .find('td')
            .slice(startCellIndex, endCellIndex + 1)
        );
      });
    // Highlight them
    this.$selection.addClass('selected');
  }

  deselect() {
    var selection = window.getSelection ? getSelection() : null;
    selection && selection.empty();
  }

  getArraySelectionText() {
    var rowData = {},
      data = [];

    var prevRowIndex = null;

    if(this.$selection) {
      this.$selection.each(function() {
        var rowIndex = $(this).parent().index();
        rowData[rowIndex] = rowData[rowIndex] || [];
        rowData[rowIndex].push($(this).text());
      });

      for ( var i in rowData ) {
        data.push(rowData[i]);
      }
    }

    return data;
  }

  getSelectionText() {
    var rowData = {},
      data = [];

    var prevRowIndex = null;

    this.$selection.each(function() {
      var rowIndex = $(this).parent().index();
      rowData[rowIndex] = rowData[rowIndex] || [];
      rowData[rowIndex].push($(this).text());
    });

    for ( var i in rowData ) {
      data.push(rowData[i].join("\t"));
    }

    return data.join("\n");
  }

  clipboardCopyHandler(e) {
    e.originalEvent.clipboardData.setData('text/plain', this.getSelectionText());
    e.preventDefault();
  }

}

export default TableSelection;