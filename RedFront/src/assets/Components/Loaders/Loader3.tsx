import styled from "styled-components";

const Loader3 = () => {
  return (
    <Container className="dark">
      <StyledWrapper>
        <svg className="pl" width={240} height={240} viewBox="0 0 240 240">
          <circle
            className="pl__ring pl__ring--a"
            cx={120}
            cy={120}
            r={105}
            fill="none"
            strokeWidth={20}
            strokeDasharray="0 660"
            strokeDashoffset={-330}
            strokeLinecap="round"
          />
          <circle
            className="pl__ring pl__ring--b"
            cx={120}
            cy={120}
            r={35}
            fill="none"
            strokeWidth={20}
            strokeDasharray="0 220"
            strokeDashoffset={-110}
            strokeLinecap="round"
          />
          <circle
            className="pl__ring pl__ring--c"
            cx={85}
            cy={120}
            r={70}
            fill="none"
            strokeWidth={20}
            strokeDasharray="0 440"
            strokeLinecap="round"
          />
          <circle
            className="pl__ring pl__ring--d"
            cx={155}
            cy={120}
            r={70}
            fill="none"
            strokeWidth={20}
            strokeDasharray="0 440"
            strokeLinecap="round"
          />
        </svg>
        {/* <AnimatedText>Unasam Congresos</AnimatedText> */}
      </StyledWrapper>
    </Container>
  );
};

const Container = styled.div`
  background: transparent;
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100vh;
`;

const StyledWrapper = styled.div`
  display: flex;
  flex-direction: column;
  align-items: center;

  .pl {
    width: 6em;
    height: 6em;
  }

  .pl__ring {
    animation: ringA 2s linear infinite;
  }

  .pl__ring--a {
    stroke: #ff7a00;
  }

  .pl__ring--b {
    animation-name: ringB;
    stroke: #007e4a;
  }

  .pl__ring--c {
    animation-name: ringC;
    stroke: #0087c0;
  }

  .pl__ring--d {
    animation-name: ringD;
    stroke: #004eae;
  }

  /* Animaciones de los círculos */
  @keyframes ringA {
    from,
    4% {
      stroke-dasharray: 0 660;
      stroke-width: 20;
      stroke-dashoffset: -330;
    }
    12% {
      stroke-dasharray: 60 600;
      stroke-width: 30;
      stroke-dashoffset: -335;
    }
    32% {
      stroke-dasharray: 60 600;
      stroke-width: 30;
      stroke-dashoffset: -595;
    }
    40%,
    54% {
      stroke-dasharray: 0 660;
      stroke-width: 20;
      stroke-dashoffset: -660;
    }
    62% {
      stroke-dasharray: 60 600;
      stroke-width: 30;
      stroke-dashoffset: -665;
    }
    82% {
      stroke-dasharray: 60 600;
      stroke-width: 30;
      stroke-dashoffset: -925;
    }
    90%,
    to {
      stroke-dasharray: 0 660;
      stroke-width: 20;
      stroke-dashoffset: -990;
    }
  }

  @keyframes ringB {
    from,
    12% {
      stroke-dasharray: 0 220;
      stroke-width: 20;
      stroke-dashoffset: -110;
    }
    20% {
      stroke-dasharray: 20 200;
      stroke-width: 30;
      stroke-dashoffset: -115;
    }
    40% {
      stroke-dasharray: 20 200;
      stroke-width: 30;
      stroke-dashoffset: -195;
    }
    48%,
    62% {
      stroke-dasharray: 0 220;
      stroke-width: 20;
      stroke-dashoffset: -220;
    }
    70% {
      stroke-dasharray: 20 200;
      stroke-width: 30;
      stroke-dashoffset: -225;
    }
    90% {
      stroke-dasharray: 20 200;
      stroke-width: 30;
      stroke-dashoffset: -305;
    }
    98%,
    to {
      stroke-dasharray: 0 220;
      stroke-width: 20;
      stroke-dashoffset: -330;
    }
  }

  @keyframes ringC {
    from {
      stroke-dasharray: 0 440;
      stroke-width: 20;
      stroke-dashoffset: 0;
    }
    8% {
      stroke-dasharray: 40 400;
      stroke-width: 30;
      stroke-dashoffset: -5;
    }
    28% {
      stroke-dasharray: 40 400;
      stroke-width: 30;
      stroke-dashoffset: -175;
    }
    36%,
    58% {
      stroke-dasharray: 0 440;
      stroke-width: 20;
      stroke-dashoffset: -220;
    }
    66% {
      stroke-dasharray: 40 400;
      stroke-width: 30;
      stroke-dashoffset: -225;
    }
    86% {
      stroke-dasharray: 40 400;
      stroke-width: 30;
      stroke-dashoffset: -395;
    }
    94%,
    to {
      stroke-dasharray: 0 440;
      stroke-width: 20;
      stroke-dashoffset: -440;
    }
  }

  @keyframes ringD {
    from,
    8% {
      stroke-dasharray: 0 440;
      stroke-width: 20;
      stroke-dashoffset: 0;
    }
    16% {
      stroke-dasharray: 40 400;
      stroke-width: 30;
      stroke-dashoffset: -5;
    }
    36% {
      stroke-dasharray: 40 400;
      stroke-width: 30;
      stroke-dashoffset: -175;
    }
    44%,
    50% {
      stroke-dasharray: 0 440;
      stroke-width: 20;
      stroke-dashoffset: -220;
    }
    58% {
      stroke-dasharray: 40 400;
      stroke-width: 30;
      stroke-dashoffset: -225;
    }
    78% {
      stroke-dasharray: 40 400;
      stroke-width: 30;
      stroke-dashoffset: -395;
    }
    86%,
    to {
      stroke-dasharray: 0 440;
      stroke-width: 20;
      stroke-dashoffset: -440;
    }
  }
`;

// const gradientAnimation = keyframes`
//   0% {
//     background-position: 0% 50%;
//   }
//   50% {
//     background-position: 100% 50%;
//   }
//   100% {
//     background-position: 0% 50%;
//   }
// `;

// const AnimatedText = styled.h1`
//   font-family: 'Montserrat', sans-serif;
//   font-size: clamp(1.5rem, 4vw, 3rem);
//   text-align: center;
//   margin-top: 20px;
//   background: linear-gradient(270deg, #ff7a00, #007e4a, #0087c0, #004eae);
//   background-size: 400% 400%;
//   -webkit-background-clip: text;
//   -webkit-text-fill-color: transparent;
// //   animation: ${gradientAnimation} 5s ease infinite;
// `;

export default Loader3;
