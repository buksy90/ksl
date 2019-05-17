const Utils = {

  getDateOption: function (date) {
    const days = ['Nedeľa', 'Pondelok', 'Utorok', 'Streda', 'Štvrtok', 'Piatok', 'Sobota'];
    const actualDate = new Date(date);
    const getDay = actualDate.getDay();
    const getDate = actualDate.getDate();
    const getMonth = actualDate.getMonth() + 1;

    return `${getDate}.${getMonth} ${days[getDay]}`;
  },

  getPlayTime: function (time) {
    const currentDate = new Date(time);
    const hours = currentDate.getHours();
    const minutes = currentDate.getMinutes();

    if (minutes < 10) {
      return `${hours}:0${minutes}`
    }
    
    return `${hours}:${minutes}`;
  }

}

export default Utils;