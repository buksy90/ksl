import React, { Component } from 'react';
import provider from "../dataProvider";
import Utils from "../utils";

export default class Schedule extends Component {
  constructor(props) {
    super(props);
    this.state = {
      dates: []
    };

    this.fetchListOfPlayingDates();
  }

  fetchListOfPlayingDates() {
    provider.getListOfPlayingDates().then(data => {
      this.setState({ dates: data.matchDays });
    })
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
                  const kslDate = Utils.getDateOption(dateObj.date);
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