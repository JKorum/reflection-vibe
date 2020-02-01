import React, { Fragment, useState, useEffect } from "react";
import ReactDOM from "react-dom";
import uuid from "uuid/v1";

const $target = document.getElementById("img-action-bar");
const $targets = document.getElementsByClassName("img-action-bars");

const heartId = uuid();
const likersInfoId = uuid();

const ImgActionBar = ({ target: { dataset }, autoUpdate }) => {
  const [liked, setLiked] = useState(+dataset.liked);
  const [likers, setLikers] = useState(dataset.likers);
  const [others, setOthers] = useState(+dataset.others);

  useEffect(() => {
    /* enable auto update only for post page */
    if (autoUpdate) {
      const timer = setInterval(() => {
        updateLikersLine();
      }, 20000);
      return () => {
        clearInterval(timer);
      };
    }
  }, []);

  const updateLikersLine = async () => {
    const $likersInfo = document.getElementById(likersInfoId);
    if ($likersInfo) {
      try {
        const postId = dataset.postId;
        const res = await axios.get(`/posts/${postId}/likers`);
        if (res.status === 200) {
          const { likers, others, authUserLikedPost } = res.data;
          setLiked(authUserLikedPost);
          setLikers(likers);
          setOthers(others);
        }
      } catch (err) {
        console.log(err);
      }
    }
  };

  const handleLikeDislike = async () => {
    const postId = dataset.postId;
    const heart = document.getElementById(heartId);
    if (postId && heart) {
      try {
        const res = await axios.post(`/posts/${postId}/like`);
        if (res.status === 200) {
          /* toggle heart background */
          if (heart.classList.contains("far")) {
            setLiked(1);
          } else {
            setLiked(0);
          }
          updateLikersLine();
        }
      } catch (err) {
        console.log(err);
      }
    }
  };

  /* used in post.show */
  const handleShowComments = () => {
    const $comments = document.getElementById("comments-section");
    if ($comments) {
      const styles = window.getComputedStyle($comments);
      if (styles.getPropertyValue("display") === "none") {
        $comments.style.display = "block";
      } else {
        $comments.style.display = "none";
      }
    }
  };

  return (
    <Fragment>
      <div className="d-flex justify-content-between pt-1">
        <div>
          <button
            type="button"
            className="btn btn-link p-0 text-reset"
            onClick={handleLikeDislike}
          >
            <i
              id={heartId}
              className={`${liked ? "fas" : "far"} fa-heart fa-lg mr-1`}
            ></i>
          </button>

          <button
            type="button"
            className="btn btn-link p-0 text-reset"
            onClick={handleShowComments}
          >
            <i className="far fa-comment fa-lg"></i>
          </button>
        </div>
        <div>
          <i className="far fa-bookmark fa-lg"></i>
        </div>
      </div>
      <div id={likersInfoId}>
        {likers && (
          <small>
            Liked by{" "}
            <span>
              {likers.split(",").map((name, i, array) => {
                return i + 1 === array.length ? (
                  <Fragment key={name}>
                    <span className="font-weight-bold">{name}</span>
                    {others ? <span>,</span> : null}
                  </Fragment>
                ) : (
                  <Fragment key={name}>
                    <span className="font-weight-bold">{name}</span>
                    <span>,</span>
                  </Fragment>
                );
              })}
            </span>
            {others ? (
              <span className="text-muted"> and {others} others</span>
            ) : null}
          </small>
        )}
      </div>
    </Fragment>
  );
};

if ($target) {
  ReactDOM.render(<ImgActionBar target={$target} autoUpdate={true} />, $target);
}

if ($targets.length > 0) {
  for (let i = 0; i < $targets.length; i++) {
    ReactDOM.render(
      <ImgActionBar target={$targets[i]} autoUpdate={false} />,
      $targets[i]
    );
  }
}
