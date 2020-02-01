import React from "react";
import ReactDOM from "react-dom";
import Moment from "react-moment";
import moment from "moment";

const $targets = document.getElementsByClassName("posted-ago");

const Date = ({ date }) => (
  <small className="text-muted text-uppercase">
    <Moment date={date} fromNow />
  </small>
);

if ($targets.length > 0) {
  for (let i = 0; i < $targets.length; i++) {
    let date = $targets[i].dataset.date;
    /* convert from utc to local */
    date = moment
      .utc(date)
      .local()
      .format("YYYY-MM-DD HH:mm:ss");
    if (date) {
      ReactDOM.render(<Date date={date} />, $targets[i]);
    }
  }
}
