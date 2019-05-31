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
    const hours = currentDate.getHours().toString();
    const minutes = currentDate.getMinutes().toString();

    if (minutes < 10) {
      return hours + ":" + minutes.padStart(2, '0');
    }
    return hours + ":" + minutes
  },

  getPlayTimeforMobile: function (matchDateTime) {

    const helpArray = matchDateTime.split(' ');
    helpArray.splice(1, 1, '');

    return helpArray.join(' ');
  }

}

export default Utils;