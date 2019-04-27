import React, { PureComponent } from 'react';

export default class KslTable extends PureComponent {
  render() { 
    let data = this.props.data;
    let header = this.props.header;
    return (
      <table className="table table-hover text-center">
        <thead>
          <tr>
            {header.map((headColumn, index) => {
              return (
                <th key={index}>{headColumn}</th>
              )
            })}
          </tr>
        </thead>
        <tbody>    
            {data.map((dataColumn, indexColum) => {
                  return (
                    <tr key={indexColum}>{
                      dataColumn.map((dataRow,indexRow)=>{
                        return( <td key={indexRow}>{dataRow} </td>)
                      })
                    }</tr>
                  )
                })}
        </tbody>
      </table>
    );
  }
}