import React, { Component } from 'react';
import provider from "../dataProvider";

export default class Schedule extends Component {
  constructor(props) {
    super(props);
    this.state = {
      dates: this.fetchListOfPlayingDates() ? this.fetchListOfPlayingDates() : []
    }
  }

  fetchListOfPlayingDates() {
    provider.getListOfPlayingDates().then(data => {
      this.setState(() => ({
        dates: data.matchDays
      }));
    })
  }

  getDateOption(date) {
    const days = ['Nedeľa', 'Pondelok', 'Utorok', 'Streda', 'Štvrtok', 'Piatok', 'Sobota'];
    const actualDate = new Date(date);
    const getDay = actualDate.getDay();
    const getDate = actualDate.getDate();
    const getMonth = actualDate.getMonth() + 1;

    return `${getDate}.${getMonth} ${days[getDay]}`;
  }

  render() {
    return (
      <div className="container">
        <h1 className="display-4 border-bottom mb-4 mt-5">Rozpis</h1>
        <div className="card">
          <div className="card-body bg-light">
            <h4 className="display-6 border-bottom mb-4 ">Deň</h4>

            <select className="custom-select">
              {
                this.state.dates.map((dateObj, index) => {
                  const kslDate = this.getDateOption(dateObj.date);
                  return (
                    <option key={index} value={index}> {kslDate} </option>
                  )
                })
              }
            </select>
          </div>
        </div>
        <div className="card mt-4">
          <div className="card-body bg-info">
            There will be list of current day matches
          </div>
        </div>
      </div>
    );
  }
}