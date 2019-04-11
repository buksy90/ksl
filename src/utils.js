const Utils = {

  getDateOption: function( date ){
    const days = ['Nedeľa', 'Pondelok', 'Utorok', 'Streda', 'Štvrtok', 'Piatok', 'Sobota'];
    const actualDate = new Date(date);
    const getDay = actualDate.getDay();
    const getDate = actualDate.getDate();
    const getMonth = actualDate.getMonth() + 1;

    return `${getDate}.${getMonth} ${days[getDay]}`;
  }

}

export default Utils;