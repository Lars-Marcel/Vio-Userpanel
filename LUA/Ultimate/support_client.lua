----------------------------------------------------
------ Copyright (c) FirstOne Media 2014-2016 ------
----------------------------------------------------

local supportWin = {
    label = {},
    edit = {},
    button = {},
    window = {},
    gridlist = {},
	memo = {}
}
local function supportWindow(tickets)
	local new = false
	
	showCursor(true)
	
	supportWin.window[1] = guiCreateWindow(401, 254, 736, 353, "Support", false)
	guiWindowSetSizable(supportWin.window[1], false)
	centerWindow(supportWin.window[1])
	
	supportWin.gridlist[1] = guiCreateGridList(10, 28, 244, 343, false, supportWin.window[1])
	local column_id = guiGridListAddColumn(supportWin.gridlist[1], "ID", 0.3)
	local column_subject = guiGridListAddColumn(supportWin.gridlist[1], "Betreff", 0.3)
	local column_state = guiGridListAddColumn(supportWin.gridlist[1], "Status", 0.3)
	
	supportWin.label[1] = guiCreateLabel(264, 28, 49, 13, "Betreff:", false, supportWin.window[1])
	guiSetFont(supportWin.label[1], "default-bold-small")
	supportWin.edit[1] = guiCreateEdit(264, 45, 310, 29, "", false, supportWin.window[1])
	guiEditSetReadOnly(supportWin.edit[1], true)
	
	supportWin.button[4] = guiCreateButton(639, 45, 85, 29, "Schliessen", false, supportWin.window[1])
	guiSetProperty(supportWin.button[4], "NormalTextColour", "FFAAAAAA")
	
	supportWin.label[3] = guiCreateLabel(264, 84, 122, 16, "Nachrichten-Verlauf:", false, supportWin.window[1])
	guiSetFont(supportWin.label[3], "default-bold-small")
	supportWin.memo[1] = guiCreateMemo(264, 103, 214, 194, "Bitte wähle ein Ticket aus der Liste aus, oder erstelle ein neues Ticket.", false, supportWin.window[1])
	guiMemoSetReadOnly(supportWin.memo[1], true)
	
	supportWin.label[2] = guiCreateLabel(491, 84, 83, 15, "Nachricht:", false, supportWin.window[1])
	guiSetFont(supportWin.label[2], "default-bold-small")
	supportWin.memo[2] = guiCreateMemo(488, 103, 236, 194, "", false, supportWin.window[1])
	guiMemoSetReadOnly(supportWin.memo[2], true)
	
	supportWin.button[1] = guiCreateButton(264, 307, 214, 36, "Neues Ticket erstellen", false, supportWin.window[1])
	guiSetProperty(supportWin.button[1], "NormalTextColour", "FFAAAAAA")
	
	supportWin.button[2] = guiCreateButton(488, 307, 236, 36, "Senden", false, supportWin.window[1])
	guiSetProperty(supportWin.button[2], "NormalTextColour", "FFAAAAAA")
	
	
	addEventHandler("onClientGUIClick", supportWin.gridlist[1], function(btn, state)
		local ID = tonumber(guiGridListGetItemText(supportWin.gridlist[1], guiGridListGetSelectedItem(supportWin.gridlist[1]), 1))
		if (tickets[ID]) then
			local ticket = tickets[ID]
			
			guiSetText(supportWin.edit[1], ticket.subject)
			guiSetText(supportWin.memo[1], ticket.message)
			guiSetText(supportWin.memo[2], "")
			guiSetText(supportWin.label[2], "Deine Antwort:")
			
			guiEditSetReadOnly(supportWin.edit[1], true)
			guiMemoSetReadOnly(supportWin.memo[2], false)
		end
	end, false)
	
	addEventHandler("onClientGUIClick", supportWin.button[1], function(btn, state)
		new = true
		
		guiGridListSetSelectedItem(supportWin.gridlist[1], 0, 0)
		
		guiSetText(supportWin.label[2], "Dein Anliegen:")
		guiSetText(supportWin.edit[1], "")
		guiSetText(supportWin.memo[2], "")
		guiSetText(supportWin.memo[1], "Gib einen Betreff und Dein Anliegen an und klick auf Senden.")
		
		guiEditSetReadOnly(supportWin.edit[1], false)
		guiMemoSetReadOnly(supportWin.memo[2], false)
	end, false)
	
	addEventHandler("onClientGUIClick", supportWin.button[2], function(btn, state)
		if (new == true) then
			local subject = guiGetText(supportWin.edit[1])
			local msg = guiGetText(supportWin.memo[2])
			if (subject ~= "" and msg ~= "") then
				triggerServerEvent("newTicket", localPlayer, subject, msg)
			end
		else
			local ID = tonumber(guiGridListGetItemText(supportWin.gridlist[1], guiGridListGetSelectedItem(supportWin.gridlist[1]), 1))
			if (tickets[ID]) then
				local ticket = tickets[ID]
				if (ticket.state == "closed") then
					outputChatBox("Das Ticket ist geschlossen, öffne es um darauf zu Antworten.", 255, 100, 0)
					return
				end
				
				local answer = guiGetText(supportWin.memo[2])
				if (answer == "" or answer == " ") then return end
				
				triggerServerEvent("ticketReply", localPlayer, ID, answer)
			end
		end
		
		guiSetText(supportWin.label[2], "Dein Anliegen:")
		guiSetText(supportWin.edit[1], "")
		guiSetText(supportWin.memo[2], "")
		guiSetText(supportWin.memo[1], "Bitte wähle ein Ticket aus der Liste aus, oder erstelle ein neues Ticket.")
		
		guiEditSetReadOnly(supportWin.edit[1], true)
		guiMemoSetReadOnly(supportWin.memo[2], true)
		
		guiGridListSetSelectedItem(supportWin.gridlist[1], 0, 0)
	end, false)
	
	addEventHandler("onClientGUIClick", supportWin.button[4], function(btn, state)
		guiSetVisible(supportWin.window[1], false)
		setElementData(localPlayer, "clicked", false)
		showCursor(false)
	end, false)
	
	
	for _, ticket in pairs(tickets) do
		local row = guiGridListAddRow(supportWin.gridlist[1])
		guiGridListSetItemText(supportWin.gridlist[1], row, column_id, ticket.ID, false, false)
		guiGridListSetItemText(supportWin.gridlist[1], row, column_subject, ticket.subject, false, false)
		local state = "Geöffnet"
		if (ticket.state == "closed") then state = "Geschlossen" end
		guiGridListSetItemText(supportWin.gridlist[1], row, column_state, state, false, false)
	end
end
addEvent("showSupportWindow", true)
addEventHandler("showSupportWindow", root, supportWindow)

local supportAdmin = {
	label = {},
    button = {},
    window = {},
    gridlist = {},
    memo = {}
}
local function showTicketWindow(tickets)
	showCursor(true)
		
	supportAdmin.window[1] = guiCreateWindow(248, 162, 785, 439, "Tickets", false)
	guiWindowSetSizable(supportAdmin.window[1], false)
	centerWindow(supportAdmin.window[1])
	
	supportAdmin.gridlist[1] = guiCreateGridList(10, 32, 356, 341, false, supportAdmin.window[1])
	local column_id = guiGridListAddColumn(supportAdmin.gridlist[1], "ID", 0.2)
	local column_player = guiGridListAddColumn(supportAdmin.gridlist[1], "Spieler", 0.2)
	local column_subject = guiGridListAddColumn(supportAdmin.gridlist[1], "Betreff", 0.2)
	local column_state = guiGridListAddColumn(supportAdmin.gridlist[1], "Status", 0.2)
	
	---
	
	supportAdmin.label[4] = guiCreateLabel(376, 35, 57, 14, "Ticket-ID:", false, supportAdmin.window[1])
	guiSetFont(supportAdmin.label[4], "default-bold-small")
	
	supportAdmin.label[6] = guiCreateLabel(443, 35, 106, 14, "-", false, supportAdmin.window[1])
	
	supportAdmin.label[5] = guiCreateLabel(559, 35, 40, 14, "Status:", false, supportAdmin.window[1])
	guiSetFont(supportAdmin.label[5], "default-bold-small")
	
	supportAdmin.label[7] = guiCreateLabel(609, 35, 161, 14, "-", false, supportAdmin.window[1])
	
	supportAdmin.label[1] = guiCreateLabel(376, 59, 47, 15, "Betreff:", false, supportAdmin.window[1])
	guiSetFont(supportAdmin.label[1], "default-bold-small")
	
	supportAdmin.label[8] = guiCreateLabel(433, 59, 337, 15, "-", false, supportAdmin.window[1])
	
	supportAdmin.label[2] = guiCreateLabel(376, 84, 57, 15, "Nachricht:", false, supportAdmin.window[1])
	guiSetFont(supportAdmin.label[2], "default-bold-small")
	
	supportAdmin.memo[1] = guiCreateMemo(376, 104, 394, 147, "", false, supportAdmin.window[1])
	guiMemoSetReadOnly(supportAdmin.memo[1], true)
	
	supportAdmin.label[3] = guiCreateLabel(377, 261, 394, 16, "___________________________________________________________________________________________________", false, supportAdmin.window[1])
	
	supportAdmin.memo[2] = guiCreateMemo(376, 299, 395, 74, "", false, supportAdmin.window[1])
	
	supportAdmin.button[1] = guiCreateButton(376, 383, 155, 43, "Antworten", false, supportAdmin.window[1])
	guiSetProperty(supportAdmin.button[1], "NormalTextColour", "FFAAAAAA")
	
	supportAdmin.button[2] = guiCreateButton(615, 383, 155, 43, "Schliessen", false, supportAdmin.window[1])
	guiSetProperty(supportAdmin.button[2], "NormalTextColour", "FFAAAAAA")

	supportAdmin.label[9] = guiCreateLabel(376, 281, 65, 18, "Antworten", false, supportAdmin.window[1])
	guiSetFont(supportAdmin.label[9], "default-bold-small")
	
	supportAdmin.button[3] = guiCreateButton(95, 383, 184, 43, "-", false, supportAdmin.window[1])
	guiSetProperty(supportAdmin.button[3], "NormalTextColour", "FFAAAAAA")
	

	
	addEventHandler("onClientGUIClick", supportAdmin.gridlist[1], function(btn, state)
		local ID = tonumber(guiGridListGetItemText(supportAdmin.gridlist[1], guiGridListGetSelectedItem(supportAdmin.gridlist[1]), 1))
		if (tickets[ID]) then
			local ticket = tickets[ID]
			guiSetText(supportAdmin.label[6], ticket.ID)
			local state = "Geöffnet"
			local act = "Schliessen"
			if (ticket.state == "closed") then state = "Geschlossen" act = "Öffnen" end
			guiSetText(supportAdmin.label[7], state)
			guiSetText(supportAdmin.button[3], "Ticket "..act)
			guiSetText(supportAdmin.label[8], ticket.subject)
			guiSetText(supportAdmin.memo[1], ticket.message)
			guiSetText(supportAdmin.memo[2], "")
		end
	end, false)
	
	addEventHandler("onClientGUIClick", supportAdmin.button[3], function(btn, state)
		local ID = tonumber(guiGridListGetItemText(supportAdmin.gridlist[1], guiGridListGetSelectedItem(supportAdmin.gridlist[1]), 1))
		if (tickets[ID]) then
			local ticket = tickets[ID]
			if (ticket.state == "closed") then
				ticket.state = "open"
				guiSetText(supportAdmin.label[7], "Geöffnet")
				guiSetText(supportAdmin.button[3], "Ticket Schliessen")
				
			else
				ticket.state = "closed"
				guiSetText(supportAdmin.label[7], "Geschlossen")
				guiSetText(supportAdmin.button[3], "Ticket Öffnen")
			end
			triggerServerEvent("updateTicketState", localPlayer, ID, ticket.state)
		end
	end, false)
	
	addEventHandler("onClientGUIClick", supportAdmin.button[1], function(btn, state)
		local ID = tonumber(guiGridListGetItemText(supportAdmin.gridlist[1], guiGridListGetSelectedItem(supportAdmin.gridlist[1]), 1))
		if (tickets[ID]) then
			local ticket = tickets[ID]
			if (ticket.state == "closed") then
				outputChatBox("Das Ticket ist geschlossen, öffne es um darauf zu Antworten.", 255, 100, 0)
				return
			end
			
			local answer = guiGetText(supportAdmin.memo[2])
			if (answer == "" or answer == " ") then return end
			
			triggerServerEvent("ticketReply", localPlayer, ID, answer)
		end
	end, false)
	
	addEventHandler("onClientGUIClick", supportAdmin.button[2], function(btn, state)
		guiSetVisible(supportAdmin.window[1], false)
		showCursor(false)
		setElementData("clicked", false)
	end, false)
	
	for _, ticket in pairs(tickets) do
		local row = guiGridListAddRow(supportAdmin.gridlist[1])
		guiGridListSetItemText(supportAdmin.gridlist[1], row, column_id, ticket.ID, false, false)
		guiGridListSetItemText(supportAdmin.gridlist[1], row, column_player, ticket.player, false, false)
		guiGridListSetItemText(supportAdmin.gridlist[1], row, column_subject, ticket.subject, false, false)
		local state = "Geöffnet"
		if (ticket.state == "closed") then state = "Geschlossen" end
		guiGridListSetItemText(supportAdmin.gridlist[1], row, column_state, state, false, false)
	end
end
addEvent("showTicketWindow", true)
addEventHandler("showTicketWindow", root, showTicketWindow)

function centerWindow (center_window)
    local screenW, screenH = guiGetScreenSize()
    local windowW, windowH = guiGetSize(center_window, false)
    local x, y = (screenW - windowW) /2,(screenH - windowH) /2
    guiSetPosition(center_window, x, y, false)
end