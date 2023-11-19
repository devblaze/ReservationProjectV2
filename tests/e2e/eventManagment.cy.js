describe('Event Management', () => {
    let eventName = 'Party for Roulis ' + Date.now();

    before(() => {
        cy.adminLogin();
    });

    it('Admin to create, search, and delete an event', () => {
        // Step 1: Create Event
        cy.visit('/events/create');
        cy.get('#title').type(eventName);
        cy.get('#description').type('Party of Roulis with other cats');
        cy.get('#start_date').type('2023-10-30T03:00');
        cy.get('#end_date').type('2023-10-31T03:00');
        cy.get('#location').type('Ioannina, Greece');
        cy.get('.mt-4').click();
        cy.get('.notification-container').contains('Event created successfully!').should('be.visible');

        // Confirm redirection after event creation
        cy.url().should('include', '/events');

        // Step 2: Search Event
        cy.visit('/events');
        cy.get('#search-dropdown').type(eventName);
        cy.contains('.event-name', eventName).should('be.visible').click();

        // Step 3: Delete Event
        cy.contains('.event-name', eventName)
        cy.get('.delete-event-button').click();
        cy.get('.delete-event-confirm', { timeout: 30000 }).should('be.visible').click();
        cy.get('.notification-container').contains('Event deleted successfully!').should('be.visible');

        // Confirm redirection after event creation
        cy.url().should('include', '/events');

        // Step 4: Check that the Event is deleted
        cy.visit('/events');
        cy.get('#search-dropdown').type(eventName);
        cy.contains('.event-name', eventName).should('not.exist');
    });

    afterEach(() => {
        cy.window().then((win) => {
            // expect(win.console.error).to.have.callCount(0);
            // expect(win.console.warn).to.have.callCount(0);
        });
    });
});
