// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyB88WYN5HsqkfvFsbg6o6e8ZjzLbxFnruQ",
  authDomain: "taskbuddy-485b1.firebaseapp.com",
  projectId: "taskbuddy-485b1",
  storageBucket: "taskbuddy-485b1.appspot.com",
  messagingSenderId: "994662951221",
  appId: "1:994662951221:web:e8236bc27ec651f56d447c",
  measurementId: "G-GSF626SCHE"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);
