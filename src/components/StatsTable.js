import React, { PureComponent } from 'react';

export default class StatsTable extends PureComponent {
  render() {
    let data = this.props.data;
    return (
      <table className="table table-hover text-center">
        <thead>
          <tr>
            {data[0].map((headColumn, index) => {
              return (
                <th key={index}>{headColumn}</th>
              )
            })}
          </tr>
        </thead>
        <tbody>
          {
            data.filter((row, index) => index !== 0)
              .map((row, index) => {
                return (
                  <tr key={index}>
                    {row.map((col, j) =>
                      <td key={j}> {col} </td>)}
                  </tr>
                );
              })}
        </tbody>
      </table>
    );
  }
}