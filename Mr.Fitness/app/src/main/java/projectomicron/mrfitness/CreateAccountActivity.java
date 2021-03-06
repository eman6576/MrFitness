package projectomicron.mrfitness;

import android.app.ProgressDialog;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.TextView;

/**
 * This class is an AppCompatActivity class that facilitates the creating account functionality for
 * a user.
 * Created by Emanuel Guerrero on 11/24/2015.
 */
public class CreateAccountActivity extends AppCompatActivity implements View.OnClickListener,
                                            AdapterView.OnItemSelectedListener {
    /**
     * Instance variables only visible in the CreateAccountActivity class. These are the components
     * of the view.
     */
    private EditText firstNameInputField;
    private EditText lastNameInputField;
    private EditText ageInputField;
    private EditText userNameInputField;
    private EditText passWordInputField;
    private EditText certificationNumberInputField;
    private EditText insuranceNumberInputField;
    private Spinner reasonForUseSpinner;
    private Spinner trainerSpinner;
    private Button submitButton;
    private Button backToLoginButton;
    private TextView errorMessageLabel;
    private TextView trainerTextLabel;
    private TextView certificationNumberTextLabel;
    private TextView insuranceNumberTextLabel;
    private ProgressDialog dialog;

    /**
     * Instance variables only visible in the CreateAccountActivity class. These are the fields that
     * store the data that the user enters.
     */
    private String userName;
    private String passWord;
    private String firstName;
    private String lastName;
    private int age = 0;
    private int reasonForUse = -1;
    private int trainerID = 0;
    private int certificationNumber = 0;
    private int insuranceNumber = 0;

    /**
     * Overrides the onCreate method inherited from AppCompatActivity to get the references for the
     * components in the view.
     * @param savedInstanceState
     */
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_create_account);

        //Get references to the text boxes
        firstNameInputField = (EditText) findViewById(R.id.firstNameTextBox);
        lastNameInputField = (EditText) findViewById(R.id.lastNameTextBox);
        ageInputField = (EditText) findViewById(R.id.ageTextBox);
        userNameInputField = (EditText) findViewById(R.id.usernameTextBox);
        passWordInputField = (EditText) findViewById(R.id.passwordTextBox);
        certificationNumberInputField = (EditText) findViewById(R.id.certificationNumberTextBox);
        insuranceNumberInputField = (EditText) findViewById(R.id.insuranceNumberTextBox);

        //Get references to the text labels
        errorMessageLabel = (TextView) findViewById(R.id.errorMessageTextLabel);
        trainerTextLabel = (TextView) findViewById(R.id.trainerTextLabel);
        certificationNumberTextLabel = (TextView) findViewById(R.id.certificationNumberTextLabel);
        insuranceNumberTextLabel = (TextView) findViewById(R.id.insuranceNumberTextLabel);

        //Get references to the spinners and populate them with the String array lists
        reasonForUseSpinner = (Spinner) findViewById(R.id.reasonForUseSpinner);
        trainerSpinner = (Spinner) findViewById(R.id.trainerSpinner);
        //Create ArrayAdapters using the string resource arrays and a default spinner layout
        ArrayAdapter<CharSequence> adapter1 = ArrayAdapter.createFromResource(this,
                R.array.reasonsForUseArray, android.R.layout.simple_spinner_item);
        ArrayAdapter<CharSequence> adapter2 = ArrayAdapter.createFromResource(this,
                R.array.trainersArray, android.R.layout.simple_spinner_item);
        //Specify the layouts to use when the list of choices appear
        adapter1.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        adapter2.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        //Apply the adapters to the spinners
        reasonForUseSpinner.setAdapter(adapter1);
        reasonForUseSpinner.setSelection(0, false);
        trainerSpinner.setAdapter(adapter2);
        trainerSpinner.setSelection(0, false);

        //Set setOnItemSelectedListeners for the spinners
        reasonForUseSpinner.setOnItemSelectedListener(this);
        trainerSpinner.setOnItemSelectedListener(this);

        //Get references for the buttons
        submitButton = (Button) findViewById(R.id.submitButton);
        backToLoginButton = (Button) findViewById(R.id.backToLoginButton);

        //Set onClickListeners for the buttons
        submitButton.setOnClickListener(this);
        backToLoginButton.setOnClickListener(this);
    }

    /**
     * Overrides the onDestroy method inherited from AppCompatActivity to clean up the references to
     * the components of the view.
     */
    @Override
    protected void onDestroy() {
        super.onDestroy();
        firstNameInputField = null;
        lastNameInputField = null;
        ageInputField = null;
        userNameInputField = null;
        passWordInputField = null;
        certificationNumberInputField = null;
        insuranceNumberInputField = null;
        reasonForUseSpinner = null;
        trainerSpinner = null;
        submitButton = null;
        backToLoginButton = null;
        errorMessageLabel = null;
        trainerTextLabel = null;
        certificationNumberTextLabel = null;
        insuranceNumberTextLabel = null;
        dialog = null;
    }

    /**
     * Redirects a user to a new activity.
     * @param intent a new activity to start
     */
    public void onSwitch(Intent intent) {
        startActivity(intent);
    }

    /**
     * Implements the onClick method in the View.OnClickListener Interface to add the event
     * listeners to the buttons.
     * @param v the view of the activity class
     * @precondition firstNameInputField.getText().toString.size() > 0
     * @precondition lastNameInputField.getText().toString.size() > 0
     * @precondition ageInputField.getText() > 0
     * @precondition certificationNumberInputField.getText() > 0
     * @precondition insuranceNumberInputField.getText() > 0
     * @precondition userNameInputField.getText().toString().size() > 0
     * @precondition passwordInputField.getText().toString().size() > 0
     * @precondition trainerID > 0
     * @precondition reasonForUse == 1 || reasonForUse == 2
     */
    @Override
    public void onClick(View v) {
        switch (v.getId()) {
            case R.id.submitButton:
                //Get the input that the user typed in the text boxes
                userName = userNameInputField.getText().toString();
                passWord = passWordInputField.getText().toString();
                firstName = firstNameInputField.getText().toString();
                lastName = lastNameInputField.getText().toString();
                try {
                    age = Integer.parseInt(ageInputField.getText().toString());
                }
                catch (NumberFormatException e) {
                    age = 0;
                }

                //Check if any of the input is blank
                if (userName.equals("") || passWord.equals("") || firstName.equals("") ||
                        lastName.equals("") || age == 0) {
                    //Set the error message label letting the user know that not all of the fields
                    //were entered
                    errorMessageLabel.setText(R.string.errorMessageTextLabelMissingField);
                    //Make the error message label visible
                    errorMessageLabel.setVisibility(View.VISIBLE);
                    break;
                }
                else {
                    //Check the user role that the user selected
                    switch (reasonForUse) {
                        case 1:
                            //Check if the user selected a trainer
                            if (trainerID == 0) {
                                //Set the error message label letting the user know that they need
                                //to select a trainer
                                errorMessageLabel.setText(R.string.
                                                            errorMessageTextLabelNoTrainerSelected);
                                //Make the error message label visible
                                errorMessageLabel.setVisibility(View.VISIBLE);
                                break;
                            }
                            else {
                                //Start the background thread of authenticating the user creating an
                                //account
                                new CreateAccountAuthentication().execute();
                                break;
                            }
                        case 2:
                            //Get the input that the user typed in for the certification number
                            //and the insurance number
                            try {
                                certificationNumber = Integer.parseInt(certificationNumberInputField.
                                        getText().toString());
                                insuranceNumber = Integer.parseInt(insuranceNumberInputField.
                                        getText().toString());
                            }
                            catch (NumberFormatException e) {
                                e.printStackTrace();
                                //Set the error message letting the user know that they need to fill
                                //out the certification number and/or insurance number
                                errorMessageLabel.setText(R.string.
                                            errorMessageTextLabelNoCertificationOrInsuranceNumber);
                                //Make the error message label visible
                                errorMessageLabel.setVisibility(View.VISIBLE);
                            }
                            //Check if the user entered the certification number and insurance
                            //number
                            if (certificationNumber == 0) {
                                //Set the error message label letting the user know that they need
                                //to provide a certification number
                                errorMessageLabel.setText(R.string.
                                        errorMessageTextLabelNoCertificationNumber);
                                //Make the error message label visible
                                errorMessageLabel.setVisibility(View.VISIBLE);
                                break;
                            }
                            else if (insuranceNumber == 0) {
                                //Set the error message label letting the user know that they need
                                //to provide a insurance number
                                errorMessageLabel.setText(R.string.
                                        errorMessageTextLabelNoInsuranceNumber);
                                //Make the error message label visible
                                errorMessageLabel.setVisibility(View.VISIBLE);
                                break;
                            }
                            else {
                                //Start the background thread of authenticating the user creating an
                                //account
                                new CreateAccountAuthentication().execute();
                                break;
                            }
                        default:
                            //Set the error message label letting the user know that they need to
                            //select a role
                            errorMessageLabel.setText(R.string.
                                    errorMessageTextLabelNoUserRoleSelected);
                            //Make the error message label visible
                            errorMessageLabel.setVisibility(View.VISIBLE);
                            break;
                    }
                    break;
                }
            case R.id.backToLoginButton:
                new Thread(new Runnable() {
                    @Override
                    public void run() {
                        //Set an intent to redirect the user to the LoginActivity activity
                        Intent intent = new Intent(getApplicationContext(), LoginActivity.class);
                        //Start the next activity
                        onSwitch(intent);
                    }
                }).start();
                break;
            default:
                break;
        }
    }

    /**
     * Implements the onItemSelected method in the AdapterView.OnItemSelectedListener Interface to
     * add the event listeners to the spinners of when the user makes a selection.
     * @param parent the actual spinner that triggered the event
     * @param view the view of the activity
     * @param position the location of the selected item in the spinner
     * @param id the id of the spinner component that triggered the event
     */
    @Override
    public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
        switch (parent.getId()) {
            case R.id.reasonForUseSpinner:
                //Get the input from the reason for use spinner
                String reasonForUseFromSpinner = parent.getItemAtPosition(position).toString();
                if (reasonForUseFromSpinner.equals("Client")) {
                    //Set the reasonForUse instance field to zero
                    reasonForUse = 1;
                    //Make the trainer spinner and it's associated text label visible
                    trainerTextLabel.setVisibility(View.VISIBLE);
                    trainerSpinner.setVisibility(View.VISIBLE);
                    //Set the certification number input field, insurance number input field, and
                    //their associated text labels to invisible if the user changed their mind
                    certificationNumberTextLabel.setVisibility(View.INVISIBLE);
                    certificationNumberInputField.setVisibility(View.INVISIBLE);
                    insuranceNumberTextLabel.setVisibility(View.INVISIBLE);
                    insuranceNumberInputField.setVisibility(View.INVISIBLE);
                    break;
                }
                else if (reasonForUseFromSpinner.equals("Trainer")) {
                    //Set the reasonForUse instance field to one
                    reasonForUse = 2;
                    //Make the certification number input field, insurance number input field, and
                    //their associated text labels visible
                    certificationNumberTextLabel.setVisibility(View.VISIBLE);
                    certificationNumberInputField.setVisibility(View.VISIBLE);
                    insuranceNumberTextLabel.setVisibility(View.VISIBLE);
                    insuranceNumberInputField.setVisibility(View.VISIBLE);
                    //Set the trainer spinner and it's associated text label invisible if the user
                    //changed their mind
                    trainerTextLabel.setVisibility(View.INVISIBLE);
                    trainerSpinner.setVisibility(View.INVISIBLE);
                    break;
                }
                else {
                    //Set the reasonForUse instance field back to negative one
                    reasonForUse = -1;
                    //Set the trainerSpinner, certification number input field, insurance input
                    //field and their associated text labels to invisible
                    trainerTextLabel.setVisibility(View.INVISIBLE);
                    trainerSpinner.setVisibility(View.INVISIBLE);
                    certificationNumberTextLabel.setVisibility(View.INVISIBLE);
                    certificationNumberInputField.setVisibility(View.INVISIBLE);
                    insuranceNumberTextLabel.setVisibility(View.INVISIBLE);
                    insuranceNumberInputField.setVisibility(View.INVISIBLE);
                    break;
                }
            case R.id.trainerSpinner:
                //Get the input from the trainer spinner
                String trainerIDSpinner = parent.getItemAtPosition(position).toString();
                if (trainerIDSpinner.equals("Please Select")) {
                    //Set the trainerID instance field to zero
                    trainerID = getResources().getIntArray(R.array.trainersIDArray)
                            [parent.getSelectedItemPosition()];
                    break;
                }
                else {
                    //Set the trainerID instance field to the trainer id of the trainer that is
                    //selected from the spinner
                    trainerID = getResources().getIntArray(R.array.trainersIDArray)
                            [parent.getSelectedItemPosition()];
                    break;
                }
            default:
                break;
        }
    }

    /**
     * Implements the onNothingSelected method in the AdapterView.OnItemSelectedListener Interface to
     * add the event listeners to the spinners of when the user makes no selection.
     * @param parent
     */
    @Override
    public void onNothingSelected(AdapterView<?> parent) {
        //Set the reasonForUse instance field to negative one
        reasonForUse = -1;
    }

    /**
     * This is a subclass of the AsyncTask class that manages the creating account authentication
     * of an user.
     */
    class CreateAccountAuthentication extends AsyncTask<String, String, String> {
        /**
         * Overrides the onPreExecute method inherited from AsyncTask to show a dialog.
         */
        @Override
        protected void onPreExecute() {
            //Show a dialog letting the user know that the login process has begun
            dialog = new ProgressDialog(CreateAccountActivity.this);
            dialog.setMessage("Creating Account...");
            dialog.setIndeterminate(false);
            dialog.setCancelable(true);
            dialog.show();
        }

        /**
         * Implements the doInBackground method in the Interface that AsyncTask implements.
         * @param params auto-generated from the compiler
         * @return a String that indicates if the process is complete
         */
        @Override
        protected String doInBackground(String... params) {
            //Declare an AccountManager object passing in the information that the user typed in
            AccountManager accountManager = new AccountManager(0, userName, passWord, firstName,
                                                lastName, age, reasonForUse, trainerID,
                                                certificationNumber, insuranceNumber);

            //Invoke the method to creating the user's account
            //Store the JSON message in a variable
            String createAccountStatus = accountManager.createAccount();
            if (createAccountStatus.equals("The username is already taken!")) {
                //Let the user know that the username entered is already taken
                CreateAccountActivity.this.runOnUiThread(new Runnable() {
                    @Override
                    public void run() {
                        //Set the error message label letting the user know that the username is
                        //already taken
                        errorMessageLabel.setText(R.string.
                                                        errorMessageTextLabelUserNameAlreadyTaken);
                        //Make the error message label visible
                        errorMessageLabel.setVisibility(View.VISIBLE);
                    }
                });
            }
            else if (createAccountStatus.equals("Not all fields were entered!")) {
                //Let the user know that not all of the fields were entered when the data was sent
                //to the database
                CreateAccountActivity.this.runOnUiThread(new Runnable() {
                    @Override
                    public void run() {
                        //Set the error message letting the user know that not all of the fields
                        //were entered
                        errorMessageLabel.setText(R.string.errorMessageTextLabelMissingField);
                        //Make the error message label visible
                        errorMessageLabel.setVisibility(View.VISIBLE);
                    }
                });
            }
            else if (createAccountStatus.equals("Account has been created successfully!")) {
                //Let the user know that their account has been created successfully and to go back
                //to the login
                CreateAccountActivity.this.runOnUiThread(new Runnable() {
                    @Override
                    public void run() {
                        //Set the error message letting the user know that their account has been
                        //successfully created and to go back to the login
                        errorMessageLabel.setText(R.string.
                                                errorMessageTextLabelAccountCreatedSuccessfully);
                        //Make the error message label visible
                        errorMessageLabel.setVisibility(View.VISIBLE);
                    }
                });
            }
            else {
                //Let the user know that there was a connection error when connecting to
                //the database
                CreateAccountActivity.this.runOnUiThread(new Runnable() {
                    @Override
                    public void run() {
                        //Set the error message letting the user know that there was a connection
                        //error
                        errorMessageLabel.setText(R.string.errorMessageTextLabelConnectionError);
                        //Make the error message label visible
                        errorMessageLabel.setVisibility(View.VISIBLE);
                    }
                });
            }

            return null;
        }

        /**
         * Overrides the onPostExecute method inherited from AsyncTask to close the dialog box.
         * @param s auto-generated from the compiler
         */
        @Override
        protected void onPostExecute(String s) {
            dialog.dismiss();
        }
    }
}
