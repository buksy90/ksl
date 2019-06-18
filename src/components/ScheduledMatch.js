import React, { Component } from 'react';
import Utils from '../utils';

export default class ScheduledMatch extends Component {

  render() {

    return (
      <div>
        {
          this.props.isMobile ?
            (
              <div className="card mt-4 mr ">
                <div className="card-body ">
                  <div className="row">
                    <div className="col">
                      <div className="row">
                        <h4 className={(this.props.homeScore > this.props.awayScore ? "text-success" : "text-secondary")}>
                          {this.props.home} <small>{this.props.winRatioHomeTeam}</small>
                        </h4>
                      </div>
                      <div className="row">
                        <h4 className={(this.props.awayScore > this.props.homeScore ? "text-success" : "text-secondary")} >
                          {this.props.away} <small>{this.props.winRatioAwayTeam}</small>
                        </h4>
                      </div>
                    </div>
                    <div className="col">
                      <div className="row">
                        <h4 className={(this.props.homeScore > this.props.awayScore ? "text-success" : "text-secondary")}> {this.props.homeScore} </h4>
                      </div>
                      <div className="row">
                        <h4 className={(this.props.awayScore > this.props.homeScore ? "text-success" : "text-secondary")} > {this.props.awayScore} </h4>
                      </div>
                    </div>
                    <div className="col">
                      <span>{'\u00A0'}</span>
                      <h6> {Utils.getPlayTimeforMobile(this.props.matchDate)} </h6>
                      <span>{'\u00A0'}</span>
                    </div>
                  </div>
                </div>
              </div>
            ) : (
              <div className="card mt-4">
                <div className="card-body">
                  <div className="container col-xs-6">
                    <div className="row">
                      <div className="col-lg-4 col-sm-4 col-xs-4 float-left">
                        <div className="card border-0">
                          <div className="card-body">
                            <h4 className={"text-center " + (this.props.homeScore > this.props.awayScore ? "text-success" : "text-secondary")}>{this.props.home}
                              <div><small>{this.props.winRatioHomeTeam}</small></div>
                            </h4>
                          </div>
                        </div>
                      </div>
                      <div className="col-lg-4 col-sm-4">
                        <div className="card border-0">
                          <div className="card-body">
                            <h4 className="text-center">
                              <span className={(this.props.homeScore > this.props.awayScore ? "text-success" : "text-secondary")}>{this.props.homeScore}</span>
                              :
                              <span className={(this.props.awayScore > this.props.homeScore ? "text-success" : "text-secondary")}>{this.props.awayScore}</span>
                              <div className="mt-3"><h6>{this.props.matchDate}</h6></div>
                            </h4>
                          </div>
                        </div>
                      </div>
                      <div className="col-lg-4 col-sm-4 col-xs-4 float-right">
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
      </div>
    )
  }
}
