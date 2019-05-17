import React, { Component } from 'react';
import ScheduledMatch from '../components/ScheduledMatch';
import provider from "../dataProvider";
import Utils from "../utils";

export default class Schedule extends Component {
  constructor(props) {
    super(props);
    this.state = {
      dates: [],
      teams: [],
      scheduledMatches: [],
      filteredMatches: [],
      dateOptionValue: '',
      teamOptionValue: 'none'
    };

    this.fetchListOfPlayingDates();
    this.fetchListOfScheduledMatches();
    this.fetchListOfTeams();

  }
  /** Data from Promise  */

  fetchListOfPlayingDates() {
    provider.getListOfPlayingDates().then(data => {
      const currentDate = new Date('July 2, 2018 23:15:30'); // Current date is chosen for testing purpose for now
      const nearestDate = data.matchDays.find(el => {
        const kslDate = new Date(el.date);
        return kslDate.getTime() > currentDate.getTime()
      })

      this.setState({
        dates: data.matchDays,
        dateOptionValue: nearestDate.date
      });
    })
  }

  fetchListOfTeams() {
    provider.getMenuTeamsList().then(data => {
      this.setState({
        teams: data.teams,
      });
    })
  }

  fetchListOfScheduledMatches() {
    provider.getListOfScheduledMatches().then(data => {
      this.setState({
        scheduledMatches: data.matches,
        filteredMatches: data.matches.filter(el => { return this.state.dateOptionValue.toString() === el.date.date.toString() })
      })
    })
  }
  /************************************************************************************************************************************ */

  /** Event functions - Date Selection and Team Selection */
  handleOnDateChange = (e) => {
    const pickedDate = e.target.value
    const filteredMatches = this.state.scheduledMatches.filter(el => {
      console.log(" dateOptionValue ETARGET " + e.target.value.toString())
      // Display list of scheduled matches for particular date or in case you chose team also, display scheduled matches based on selected date and team
      if (this.state.teamOptionValue.toString() !== "none") {
        return (
          (this.state.teamOptionValue.toString() === el.home_team.id.toString() || this.state.teamOptionValue.toString() === el.away_team.id.toString())
          &&
          pickedDate.toString() === el.date.date.toString()
        )
      } else {
        return pickedDate.toString() === el.date.date.toString()
      }
    });

    this.setState({
      filteredMatches: filteredMatches,
      dateOptionValue: pickedDate
    })
  }

  handleOnTeamChange = (e) => {
    const pickedTeam = e.target.value;

    // Display list of scheduled matches for particular team or in case you chose date also, display scheduled matches based on selected date and team
    const filteredMatches = this.state.scheduledMatches.filter(el => {
      if (this.state.dateOptionValue.toString() !== "none") {

        if (pickedTeam.toString() === "none") {
          return this.state.dateOptionValue.toString() === el.date.date.toString()
        } else {
          return (
            this.state.dateOptionValue.toString() === el.date.date.toString()
            &&
            (pickedTeam.toString() === el.home_team.id.toString() || pickedTeam.toString() === el.away_team.id.toString())
          )
        }
      } else {
        return pickedTeam.value.toString() === el.home_team.id.toString() || pickedTeam.toString() === el.away_team.id.toString()
      }
    });
    this.setState({
      filteredMatches: filteredMatches,
      teamOptionValue: pickedTeam
    })
  }
  /************************************************************************************************************************************ */
  // HTML
  render() {
    return (
      <div className="container">
        <h1 className="display-4 border-bottom mb-4 mt-5">Rozpis</h1>
        <div className="container ">
          <div className="row">
            <div className="col-lg-6 col-sm-6 col-xs-12">
              <div className="card">
                <div className="card-body bg-light">
                  <h4 className="display-6 border-bottom mb-4 ">Deň</h4>
                  <select className="custom-select" onChange={this.handleOnDateChange} value={this.state.dateOptionValue}>
                    {
                      this.state.dates.map((dateObj, index) => {
                        const kslDate = Utils.getDateOption(dateObj.date);
                        return (
                          <option key={index} value={dateObj.date}> {kslDate} </option>
                        )
                      })
                    }
                  </select>
                </div>
              </div>
            </div>
            <div className="col-lg-6 col-sm-6 col-xs-12">
              <div className="card">
                <div className="card-body bg-light">
                  <h4 className="display-6 border-bottom mb-4 ">Tím</h4>
                  <select className="custom-select" onChange={this.handleOnTeamChange} value={this.state.teamOptionValue}>
                    <option key="none" value="none"> Vyber tím </option>
                    {
                      this.state.teams.map((teamObj, index) => {
                        return (
                          <option key={index} value={teamObj.id}> {teamObj.name} </option>
                        )
                      })
                    }
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
        {
          this.state.filteredMatches
            .map((el, index) => {
              const date = Utils.getDateOption(el.date.date);
              const matchTime = Utils.getPlayTime(el.date.datetime_human)
              const homeScore = el.home_score ? `${el.home_score}` : "0";
              const awayScore = el.away_score ? `${el.away_score}` : "0";
              return (
                <ScheduledMatch key={index}
                  home={el.home_team.short} away={el.away_team.short}
                  winRatioHomeTeam={`${el.home_team.games_won}-${el.home_team.games_lost}`}
                  winRatioAwayTeam={`${el.away_team.games_won}-${el.away_team.games_lost}`}
                  homeScore={parseInt(homeScore)}
                  awayScore={parseInt(awayScore)}
                  matchDate={`${date} ${matchTime}`} />
              )
            })
        }
      </div>
    );
  }
}