import React, { Component } from 'react';

export default class ScheduledMatch extends Component {

  render() {
    return (
      <div className="card mt-4">
        <div className="card-body">
          <div className="container col-xs-4">
            <div className="row">
              <div className="col-lg-4 col-sm-4 col-xs-12 float-left">
                <div className="card border-0">
                  <div className="card-body">
                    <h4 className={"text-center " + (this.props.homeScore > this.props.awayScore ? "text-success" : "text-secondary")}>{this.props.home}
                      <div><small>{this.props.winRatioHomeTeam}</small></div>
                    </h4>
                  </div>
                </div>
              </div>
              <div className=" col-lg-4 col-sm-4 col-xs-12">
                <div className="card border-0">
                  <div className="card-body">
                    <h4 className="text-center">
                      <span className={(this.props.homeScore > this.props.awayScore ? "text-success" : "text-secondary")}>{this.props.homeScore}</span>
                      {'\u00A0'}:{'\u00A0'}
                      <span className={(this.props.awayScore > this.props.homeScore ? "text-success" : "text-secondary")}>{this.props.awayScore}</span>
                      <div><small>{this.props.matchDate}</small></div>
                    </h4>
                  </div>
                </div>
              </div>
              <div className="col-lg-4 col-sm-4 col-xs-12 float-right">
                <div className="card border-0">
                  <div className="card-body">
                    <h4 className={"text-center " + (this.props.awayScore > this.props.homeScore ? "text-success" : "text-secondary")} >{this.props.away}
                      <div><small>{this.props.winRatioAwayTeam}</small></div>
                    </h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    )
  }
}
